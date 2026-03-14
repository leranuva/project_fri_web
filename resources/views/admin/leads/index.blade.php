<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Leads</h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg">
            <h1 class="text-xl font-bold text-white mb-6">Embudo de Leads</h1>

            <form method="GET" class="mb-6 flex flex-wrap gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por email, producto, país..." class="auth-form-input max-w-xs">
                <input type="number" name="min_score" value="{{ request('min_score') }}" placeholder="Score mínimo" class="auth-form-input w-24">
                <button type="submit" class="glass-button glass-button-sm">Filtrar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="py-3 px-4 text-white/90 font-semibold">Email</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Producto</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Valor</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Score</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Cotizaciones</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr class="border-b border-white/10">
                                <td class="py-3 px-4 text-white">{{ $lead->email }}</td>
                                <td class="py-3 px-4 text-white/80">{{ $lead->producto ?? '-' }}</td>
                                <td class="py-3 px-4 text-white/80">${{ number_format($lead->valor ?? 0, 2) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $lead->score >= 70 ? 'bg-green-500/30 text-green-200' : ($lead->score >= 40 ? 'bg-yellow-500/30 text-yellow-200' : 'bg-gray-500/30 text-gray-200') }}">
                                        {{ $lead->score }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-white/80">{{ $lead->quote_count }}</td>
                                <td class="py-3 px-4 text-white/60 text-sm">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-white/60">No hay leads registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leads->hasPages())
                <div class="mt-6">{{ $leads->links() }}</div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
