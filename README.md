I am interested in creating a "multi guard" system for Laravel 12.
I like the Livewire user authentication that is bundled into Laravel 12 (called the starter kit for Livewire).
However, it does not cater for an admin panel that only an admin can access.
I worked through a number of multi guard solutions and settled on this one from Udemy:  
Laravel 11/12 - Multi-Guard Authentication System A-Z as taught by Mustapha Jibril Muhammad.
I opted not to use his "user authorization" as I like the Laravel 12 Livewire functionality found in the starter kit.
I updated the code here to use his admin panel and login forms / reset password.
First prize is a Laravel Starter kit that handles this for Livewire so that forms are updated without a server call.
My next project is to try to build same using the base code found here.
I.e. pin down Livewire first to get at that solution.

Note that I pulled in Spatie Honeypot.
I had a number of issues with this and eventually changed the code in the vendor folder.
I understand the problems associated with this but decided to comment my input and keep an eye on this.
I.e. note that if you update Spatie Honeypot a newer version may solve the problem or not.
