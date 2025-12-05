<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<p>Welcome to Chaloo, your premier destination for vehicle rentals and tour bookings. We are dedicated to providing you with the best travel experience possible.</p>
                        <p>Our mission is to connect travelers with reliable transporters and tour operators, ensuring a seamless and enjoyable journey.</p>
                        <p>Founded in 2024, Chaloo has come a long way from its beginnings. When we first started out, our passion for "Travel Made Easy" drove us to start this business.</p>
                        <p>We hope you enjoy our services as much as we enjoy offering them to you. If you have any questions or comments, please don\'t hesitate to contact us.</p>'
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Get in Touch</h2>
                            <p class="mb-4">Have questions or need assistance? We\'re here to help! Reach out to us using the contact information below.</p>
                            
                            <div class="space-y-2">
                                <p><strong>Email:</strong> support@chaloo.com</p>
                                <p><strong>Phone:</strong> +92 300 1234567</p>
                                <p><strong>Address:</strong> 123 Main Street, Lahore, Pakistan</p>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Send us a Message</h2>
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <textarea rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700"></textarea>
                                </div>
                                <button type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Send Message</button>
                            </form>
                        </div>
                    </div>'
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<p class="text-sm text-gray-500 mb-4">Last updated: ' . date('F d, Y') . '</p>
                        
                        <h3>1. Introduction</h3>
                        <p>Welcome to Chaloo. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you as to how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>
                        
                        <h3>2. Data We Collect</h3>
                        <p>We may collect, use, store and transfer different kinds of personal data about you which we have grouped together follows: Identity Data, Contact Data, Technical Data, and Usage Data.</p>
                        
                        <h3>3. How We Use Your Data</h3>
                        <p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances: Where we need to perform the contract we are about to enter into or have entered into with you.</p>
                        
                        <h3>4. Data Security</h3>
                        <p>We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorized way, altered or disclosed.</p>
                        
                        <h3>5. Contact Us</h3>
                        <p>If you have any questions about this privacy policy or our privacy practices, please contact us at support@chaloo.com.</p>'
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<p class="text-sm text-gray-500 mb-4">Last updated: ' . date('F d, Y') . '</p>
                        
                        <h3>1. Agreement to Terms</h3>
                        <p>By accessing our website, you agree to be bound by these Terms of Service and to comply with all applicable laws and regulations.</p>
                        
                        <h3>2. Use License</h3>
                        <p>Permission is granted to temporarily download one copy of the materials (information or software) on Chaloo\'s website for personal, non-commercial transitory viewing only.</p>
                        
                        <h3>3. Disclaimer</h3>
                        <p>The materials on Chaloo\'s website are provided on an \'as is\' basis. Chaloo makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
                        
                        <h3>4. Limitations</h3>
                        <p>In no event shall Chaloo or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Chaloo\'s website.</p>'
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<p>The information provided by Chaloo ("we," "us," or "our") on our website is for general informational purposes only. All information on the Site is provided in good faith, however we make no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability or completeness of any information on the Site.</p>
                        
                        <h3>External Links Disclaimer</h3>
                        <p>The Site may contain (or you may be sent through the Site) links to other websites or content belonging to or originating from third parties or links to websites and features in banners or other advertising. Such external links are not investigated, monitored, or checked for accuracy, adequacy, validity, reliability, availability or completeness by us.</p>
                        
                        <h3>Professional Disclaimer</h3>
                        <p>The Site cannot and does not contain professional advice. The information is provided for general informational and educational purposes only and is not a substitute for professional advice.</p>'
            ],
            [
                'title' => 'Sitemap',
                'slug' => 'sitemap',
                'content' => '<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Main Pages</h2>
                            <ul class="space-y-2">
                                <li><a href="/" class="text-indigo-600 hover:underline">Home</a></li>
                                <li><a href="/tours" class="text-indigo-600 hover:underline">Tours</a></li>
                                <li><a href="/vehicles" class="text-indigo-600 hover:underline">Rent a Vehicle</a></li>
                                <li><a href="/about" class="text-indigo-600 hover:underline">About Us</a></li>
                                <li><a href="/contact" class="text-indigo-600 hover:underline">Contact Us</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Legal</h2>
                            <ul class="space-y-2">
                                <li><a href="/privacy-policy" class="text-indigo-600 hover:underline">Privacy Policy</a></li>
                                <li><a href="/terms-of-service" class="text-indigo-600 hover:underline">Terms of Service</a></li>
                                <li><a href="/disclaimer" class="text-indigo-600 hover:underline">Disclaimer</a></li>
                                <li><a href="/cookie-policy" class="text-indigo-600 hover:underline">Cookie Policy</a></li>
                                <li><a href="/dmca" class="text-indigo-600 hover:underline">DMCA Policy</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4 border-b pb-2">User Account</h2>
                            <ul class="space-y-2">
                                <li><a href="/login" class="text-indigo-600 hover:underline">Login</a></li>
                                <li><a href="/register" class="text-indigo-600 hover:underline">Register</a></li>
                                <li><a href="/dashboard" class="text-indigo-600 hover:underline">Dashboard</a></li>
                            </ul>
                        </div>
                    </div>'
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'content' => '<p>This Cookie Policy explains how Chaloo uses cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.</p>
                        
                        <h3>What are cookies?</h3>
                        <p>Cookies are small data files that are placed on your computer or mobile device when you visit a website. Cookies are widely used by website owners in order to make their websites work, or to work more efficiently, as well as to provide reporting information.</p>
                        
                        <h3>Why do we use cookies?</h3>
                        <p>We use first-party and third-party cookies for several reasons. Some cookies are required for technical reasons in order for our Website to operate, and we refer to these as "essential" or "strictly necessary" cookies. Other cookies also enable us to track and target the interests of our users to enhance the experience on our Online Properties.</p>
                        
                        <h3>How can I control cookies?</h3>
                        <p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie rights by setting your preferences in the Cookie Consent Manager. The Cookie Consent Manager allows you to select which categories of cookies you accept or reject.</p>'
            ],
            [
                'title' => 'About the Author',
                'slug' => 'author',
                'content' => '<div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold mb-2">About the Author</h1>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Content Creator & Travel Enthusiast</p>
                            <div class="prose dark:prose-invert max-w-none">
                                <p>Hello! I am the lead content creator at Chaloo. With a passion for travel and technology, I strive to bring you the best tips, guides, and services to make your journeys unforgettable.</p>
                                <p>My goal is to simplify the travel experience for everyone, whether you\'re looking for a quick weekend getaway or a long-term adventure.</p>
                                <p>Feel free to connect with me through our social media channels or drop a message via the Contact Us page.</p>
                            </div>
                        </div>
                    </div>'
            ],
            [
                'title' => 'DMCA / Copyright Policy',
                'slug' => 'dmca',
                'content' => '<p>Chaloo respects the intellectual property rights of others. It is our policy to respond to any claim that Content posted on the Service infringes the copyright or other intellectual property infringement ("Infringement") of any person.</p>
                        
                        <h3>DMCA Notice of Alleged Infringement</h3>
                        <p>If you are a copyright owner, or authorized on behalf of one, and you believe that the copyrighted work has been copied in a way that constitutes copyright infringement that is taking place through the Service, you must submit your notice in writing to the attention of "Copyright Agent" via email at support@chaloo.com and include in your notice a detailed description of the alleged Infringement.</p>
                        
                        <h3>Counter-Notice</h3>
                        <p>If you believe that your Content that was removed (or to which access was disabled) is not infringing, or that you have the authorization from the copyright owner, the copyright owner\'s agent, or pursuant to the law, to post and use the material in your Content, you may send a written counter-notice to the Copyright Agent.</p>'
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
