<?php

namespace Database\Seeders;

use App\Models\WorkflowManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HelpSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of titles
        $titles = [
            'Travel Pre-Authorization',
            'Pre-Authorization',
            'Purchase',
            'Travel Reimbursement',
            'Reimbursement',
            'Pay Invoice'
        ];

        foreach ($titles as $title) {
            WorkflowManagement::updateOrCreate(['title' => $title],
            [
                'title' => $title,
                'content'=> "Content for " .$title
            ]);
        }
    }
}
