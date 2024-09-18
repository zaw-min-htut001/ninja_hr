<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'company_name' => 'Ninja Company',
            'company_email' => 'ninja@exmaple.com',
            'company_phone' => '07423142511',
            'company_address' => 'No 123 ,Hlaing Tsp ,Ninja Company',
            'contact_person' => 'Coe',
            'office_start_time' => '07:00:00',
            'office_end_time' => '17:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00'
        ];
    }
}
