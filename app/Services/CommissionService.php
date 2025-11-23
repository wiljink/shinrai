<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CommissionService
{
    /**
     * Calculates the Agent's commission and the Manager/Director overrides based on the sale.
     * This logic is based on:
     * - Project Sales: 5% less 10% Realty Share
     * - Agent Share: 60%/70%/80%/90% of the net commission
     * - Sales Manager Override: 10% of the Agent’s Broker Share (NON-Taxable)
     * - Sales Director Override: 20% of the Sales Manager Override
     * * @param Sale $sale
     * @return array
     */
    public function processSaleCommissions(Sale $sale): array
    {
        $agent = $sale->agent; // Assumes Sale model has a relationship to the User model

        // 1. Determine Total Commission (5% of sale amount)
        $commission_rate = 0.05; 
        $total_commission = $sale->amount * $commission_rate;

        // 2. Deduct Realty Share (10% of total commission)
        $realty_share_rate = 0.10;
        $realty_share = $total_commission * $realty_share_rate;
        $net_commission = $total_commission - $realty_share; // The "NET Comms"

        // 3. Determine Agent's Net Share
        // NOTE: The agent's commission_rate (60/70/80/90%) must be assigned by Admin/Sales Director during approval.
        // Assuming the rate is stored in the User model, otherwise default to 60%.
        $agent_rate = $agent->commission_rate ?? 0.60; 
        $agent_net_share = $net_commission * $agent_rate;

        // 4. Determine Broker Share (Base for Overrides)
        $broker_share = $net_commission - $agent_net_share; 

        // 5. Calculate Overrides
        // Sales Manager Override is 10% of the Agent’s Broker Share
        $sm_override_rate = 0.10; 
        $sm_override_amount = $broker_share * $sm_override_rate;

        // Sales Director Override is 20% of the Sales Manager Override
        $sd_override_rate = 0.20;
        $sd_override_amount = $sm_override_amount * $sd_override_rate;

        // 6. Record Commissions (Records are created in the 'pending' status)
        
        // Agent's Commission
        Commission::create([
            'sale_id' => $sale->id,
            'agent_id' => $agent->id,
            'amount' => $agent_net_share,
            'status' => 'pending', 
            'description' => 'Agent Net Commission (Subject to WHT)', // Brokerage Sales is Subject to WHT
        ]);

        // Sales Manager Override (Requires a lookup to find the agent's manager)
        // NOTE: For simplicity, finding the first SM and SD. In a production app, you would use a 'manager_id' field on the User model.
        $sm = User::where('role', 'sales_manager')->first();
        if ($sm) {
            Commission::create([
                'sale_id' => $sale->id,
                'agent_id' => $sm->id, 
                'amount' => $sm_override_amount,
                'status' => 'pending',
                'description' => 'Override Incentive NON-Taxable', // Itemized as “Override Incentive” NON-Taxable
            ]);
        }

        // Sales Director Override (Requires a lookup to find the director)
        $sd = User::where('role', 'sales_director')->first();
        if ($sd) {
            Commission::create([
                'sale_id' => $sale->id,
                'agent_id' => $sd->id, 
                'amount' => $sd_override_amount,
                'status' => 'pending',
                'description' => 'Sales Director Override',
            ]);
        }

        return [
            'agent_commission' => $agent_net_share,
            'sm_override' => $sm_override_amount,
            'sd_override' => $sd_override_amount,
            'net_commission' => $net_commission,
        ];
    }
}