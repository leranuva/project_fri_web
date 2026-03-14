<?php

namespace App\Http\Requests;

use App\Models\ShippingRate;
use Illuminate\Foundation\Http\FormRequest;

class CalculateQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $activeMethods = ShippingRate::active()
            ->select('method')
            ->distinct()
            ->pluck('method')
            ->toArray();

        $shippingRule = empty($activeMethods)
            ? 'required|string' // Fallback: validación básica, el controller retornará 422 con mensaje específico
            : ['required', 'string', 'in:' . implode(',', $activeMethods)];

        return [
            'product' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:99999',
            'weight' => 'required|numeric|min:0.01|max:99999',
            'unitValue' => 'required|numeric|min:0.01|max:9999999.99',
            'shippingMethod' => $shippingRule,
            'email' => 'nullable|email',
            'pais' => 'nullable|string|max:50',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product.required' => 'El producto es requerido.',
            'product.max' => 'El nombre del producto es demasiado largo.',
            'quantity.required' => 'La cantidad es requerida.',
            'quantity.min' => 'La cantidad debe ser al menos 0.01.',
            'weight.required' => 'El peso es requerido.',
            'weight.min' => 'El peso debe ser al menos 0.01 libras.',
            'unitValue.required' => 'El valor unitario es requerido.',
            'unitValue.min' => 'El valor unitario debe ser al menos 0.01.',
            'shippingMethod.required' => 'El método de envío es requerido.',
            'shippingMethod.in' => 'El método de envío seleccionado no es válido.',
        ];
    }
}
