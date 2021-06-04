## Disposable Theme v2 (phpVms v7)

This theme uses Bootstrap v4.6, Fontawesome v5+ icons to enhance the look of your phpvms installation. It is multi-language ready and designed to be compatible with my current and possible future modules.  
Template is compatible with latest dev build as of date 30.APR.21 and i will try to keep it updated as the development continues.

**Installation**

Same folder structure is used with phpvms v7, so if you have a default installation for it, then installing the themes will take only seconds.  
Just extract the zip file at the root folder of your phpvms v7 installation, and select the templates from admin section.

**Non Standard / Manual Installation**

If you want to manually upload the files or have a modified installtion of phpvms please follow the instructions below;
* Contents of public\image should be placed in your phpvms public folder.(it may be public_html according to your install)
* Contents of public\disposable should be placed in your phpvms public folder.(it may be public_html according to your install)

If you do not have an image (and disposable) folder directly under your public access folder then you may need to create them.
* Contents of public\assets\frontend\css folder should be placed in your phpvms public\assets\frontend\css folder.
* Contents of public\assets\frontend\js folder should be placed in your phpvms public\assets\frontend\js folder.

This is where the default stylesheet files are already placed, so you should be able to find them without any problems.  
But if you miss or skip this step, template will really look terrible and you would spot the problem in seconds.

* Contents of resources\lang\en folder should be placed under your phpvms resources\lang\en folder.
* Contents of resources\views\layouts folder should be placed under your phpvms resources\views\layouts folder.

**Theme Settings (via theme.json file)**
```
"name" : "Disposable_v2", // Theme Name (and also the folder name)
"extends" : "default",    // if something goes wrong and a file is missing, this saves us and default theme is used
"sidebar" : 0,            // SideBar (left) and NavBar (top) switch
"utc_clock" : 1,          // UTC Clock (javascript based)
"flight_cards" : 0,       // Display flights as cards or in a classic table style 
"flight_usedtypes" : 0,   // THIS SETTING IS DEPRECATED ! Core PhpVms provides a better solution.
"flight_bid" : 1,         // Enable Bid button at flight details page
"flight_simbrief" : 1,    // Enable Generate SimBrief OFP button at flight details page
"manual_pireps": 0,       // Hide Manual Pirep sending buttons
"sb_acspecs" : 1,         // Shows Aircraft Technical Specs Selection Dropdown at SimBrief Form
"sb_runways" : 1,         // Shows Runway Selection Drowdowns (for Origin and Destination) at SimBrief Form
"sb_routefinder" : 1,     // Enable RouteFinder modal window at SimBrief form
"sb_extrafuel" : 1,       // Enable Extra Fuel field at SimBrief form
"sb_tankering" : 1,       // Enable Tankering suggestion at SimBrief form
"sb_wxreports" : 0,       // Enable RAW Weather Reports for Origin and Destination (uses Weather Widget)
"sb_rvr" : "200",         // RVR Value of your Virtual Airline (CAT1 = 550 / CAT2 = 350 / CAT3a 200 / CAT3b 50)
"sb_rmk" : "DISPO VA"     // RMK Text to be added to your SimBrief ATC messages like "RMK/TCAS DISPO VA" (TCAS is fixed)
"total_hours" : 1,        // Show total hours at pilot roster (works separate from admin-transfer hours setting)
"roster_ident" : 0,       // Show User Ident (Callsign) at roster
"roster_ivao" : 1,        // Show IVAO ID and link to user's IVAO profile at roster
"sbrief_ivao" : 1,        // Show IVAO Prefile button at SimBrief Briefing page
"roster_vatsim" : 1,      // Show VATSIM ID and link to user's VATSIM profile at roster 
"sbrief_vatsim" : 1,      // Show VATSIM Prefile button at SimBrief Briefing page
"roster_poscon" : 0,      // Show POSCON ID at roster
"sbrief_poscon" : 0,      // Show POSCON Prefile button at SimBrief Briefing page
"sbrief_fltcrw" : 1,      // Display Flight Crew names at SimBrief Briefing page
"change_hub" : 1,         // Allow users to change their hubs (home airports) via user profile edit page 
"change_airline" : 1,     // Allow users to change their airlines via user profile edit page
"login_logo" : 1          // Show logo at login screen
```
*Important Note: Last value of the theme.json file DOES NOT NEED a comma at the end, all others must have a comma.*
*It is not a typo or an error in the file, it is how it should be*

**Re-Styling the Theme**

I tried to follow a standard on all blade files, for example all page headings use the same class (card-title) and they are all in `<h3></h3>` tags.  
All card headers are in `<h5></h5>` tags, no manual `style="..."` codes used in the blades except when it is/was really necessary etc.

If you want to change all page title's color you can add below line to the css file instead of editing dozens of blade files one by one.

`.card-title { color: pink; }` or `.card-title { font-size: 150%; color: #FFFFFF; }`

Also i tried to make the css file simple for user to edit, just the top part of the css would be enough for basic style changes. Of course you can do whatever you want in the blade files or in the css but if you are not experienced in things I kindly suggest to always have backups ;)

**IVAO and VATSIM profile links**

If you want the links to be functional please add two profile fields (check admin->users->profile fields) as below;

* name        : IVAO (this field is checked for the correct url)
* description : Ivao ID or IVAO ID (this field is displayed in the blade with the value, can be anything you wish)

* name        : VATSIM (this field is checked for the correct url)
* description : Vatsim ID or VATSIM ID (this field is displayed in the blade with the value, can be anything you wish)

Do not use any spaces in the name field while creating the profile fields, that will generate an error both during display and during user registration.  
If you already defined your profile fields, you can change their names from the admin panel or just change the profile\index.blade to reflect your settings.

**vmsAcars Users and Extended Stats (needs Disposable Tools & Widgets module)**

User profile will give you simple stats for pilots but if you are using vmsAcars as your flight tracking software, template will dedect it and enable more stats at profile page. Some directly visible some are visible with a click.

**Flights Page/View**

All the details of your flights are by default collapsed, just click the show/hide details icon to see full basic details of flights (like route, subfleets, notes)

**Footer Positioning and Content**

If you want to have a larger footer (like 2-3 lines or images/links etc), then you need to edit the css file to give it more space 'cause to keep it really where it belongs (at the bottom of the page) I had to use some definitions for it.  
To do this, head to the css file and go to end directly, you will find the definitions and simple explanations for footer there. 

**Diffences Compared to v1 series**

* Multi-language/translation support (only English provided by default)
* Configuration via theme.json file
* Ready for Disposable Modules

**Tests**

The main theme was tested with Chrome,Firefox,Safari,Opera and Ms Edge on desktop computers. Also some tests done with mobile phones and tablets.  
If you encounter problems in a specific device just let me know, maybe we can fix it.

Safe flights and enjoy,  
Disposable  
30.APR.21  

---

### Update Notes

**04.JUN.2021**
* Show/Hide Button in LiveMap Widget (thanks @derrobin154)
* Fixed missing DarkMode css/style defition for LiveMap table

**03.JUN.2021**
* German Translation (thanks @derrobin154)

**29.MAY.2021**
* Added necessary files for Dark Mode feature (darkmode.css , javascript files and some dark background images)
* Updated `app.blade.php` for being ready for Dark Mode and placed DM switch to both nav blades.
* Updated Flight Search / Flight Types dropdown. (it is now fully controlled by phpvms core)
* Removed deprecated `Dispo_FlightTypes` function from `disposable_functions.blade.php`

**22.MAY.2021**
* Added QR code to SimBrief Briefing Summary page
* Fixed System Remarks only showing the first error/remark

**12.MAY.2021**
* Added FlightMaps to Flights page
* Added a new helper for decoding days of scheduled flights (Thanks to GAE: German Air Express for their kind support)
* Added decoded days to flight card (at Flight page) and Flight details page (along with start-end days if supplied)
* Fixed some minor bugs reported by users

---

**Developer Note:**  
If you are getting "unable to locate mix file" errors in your Laravel Log, please change all occurances of `public_mix` to `public_asset` in your `app.blade.php`. Same solution may be applied to admin/app.blade.php file too.
