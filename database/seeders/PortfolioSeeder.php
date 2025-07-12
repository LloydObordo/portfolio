<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        // Sample Experiences
        Experience::create([
            'job_title' => 'Senior Full Stack Developer',
            'company' => 'Tech Solutions Inc.',
            'location' => 'New York, NY',
            'start_date' => '2022-01-01',
            'end_date' => null,
            'is_current' => true,
            'description' => 'Lead development of web applications using Laravel and Vue.js',
            'achievements' => [
                'Increased application performance by 40%',
                'Led a team of 5 developers',
                'Implemented CI/CD pipeline reducing deployment time by 60%'
            ]
        ]);

        // Sample Projects
        Project::create([
            'title' => 'E-commerce Platform',
            'description' => 'A modern e-commerce solution with advanced features',
            'detailed_description' => 'Full-featured e-commerce platform with user authentication, payment processing, inventory management, and admin dashboard.',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'AWS'],
            'image' => 'images/projects/ecommerce.jpg',
            'live_url' => 'https://demo-ecommerce.com',
            'github_url' => 'https://github.com/username/ecommerce',
            'category' => 'web-development',
            'featured' => true,
            'order' => 1
        ]);

        // Sample Skills
        $skills = [
            ['name' => 'Laravel', 'category' => 'technical', 'proficiency' => 95],
            ['name' => 'Vue.js', 'category' => 'technical', 'proficiency' => 90],
            ['name' => 'PHP', 'category' => 'technical', 'proficiency' => 95],
            ['name' => 'JavaScript', 'category' => 'technical', 'proficiency' => 90],
            ['name' => 'MySQL', 'category' => 'technical', 'proficiency' => 85],
            ['name' => 'Problem Solving', 'category' => 'soft', 'proficiency' => 95],
            ['name' => 'Team Leadership', 'category' => 'soft', 'proficiency' => 85],
            ['name' => 'Communication', 'category' => 'soft', 'proficiency' => 90],
            ['name' => 'VS Code', 'category' => 'tools', 'proficiency' => 95],
            ['name' => 'Git', 'category' => 'tools', 'proficiency' => 90],
            ['name' => 'Docker', 'category' => 'tools', 'proficiency' => 80],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}