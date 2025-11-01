@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-6">Agent Dashboard</h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">My Properties</h3>
                <p class="text-2xl">{{ $myProperties }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">My Sales</h3>
                <p class="text-2xl">{{ $mySales }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">My Collections</h3>
                <p class="text-2xl">${{ number_format($myCollections,2) }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">My Commissions</h3>
                <p class="text-2xl">${{ number_format($myCommissions,2) }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">My Incentives</h3>
                <p class="text-2xl">${{ number_format($myIncentives,2) }}</p>
            </div>
        </div>

        <!-- Example Chart: Commissions vs Incentives -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Commissions vs Incentives</h3>
            <canvas id="agentChart" width="400" height="150"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('agentChart').getContext('2d');
        const agentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Commissions', 'Incentives'],
                datasets: [{
                    label: 'Amount ($)',
                    data: [{{ $myCommissions }}, {{ $myIncentives }}],
                    backgroundColor: ['#10B981', '#F59E0B'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Commissions vs Incentives' }
                }
            }
        });
    </script>
@endsection
