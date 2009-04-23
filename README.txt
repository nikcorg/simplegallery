DISCLAIMER
--------------------------------------

Feel free to use this completely free software, but do note that you do so
on your own risk. I am not responsible for any grief or loss of data what so
ever.

Whatever you do, you're on your own, don't come crying to me.

That being said, it's very unlikely that anything like that should happen due
to SimpleGallery. SimpleGallery doesn't manipulate your original files in any
way.


INSTALLING
--------------------------------------

- Copy the files to your server.
- Rename config.dist.php config.php.
- Open config.php in a text editor and edit where you need to 
  (This step is not optional)

Now for the techical stuff, ask your techie friend if this is too hard

- If you're installing the gallery into the root folder of your website,
  you're fine, skip this step.
- If you're not, you need to do some edits:
  - in config.php set 
	$siteWebRoot = '/path/to/gallery';
    pointing to the folder you're installing to. No trailing slash.
  - in .htaccess change RewriteBase to the folder you're installing to

- If you cannot use .htaccess and mod_rewrite (ask your service provider or
  your techie friend if you're stumped over this), set 

	$useNiceUrls = false;

  in config.php

- Make sure that the /assets/img/generated is write enabled for the web server
  process. If you're not sure, make it world writable, which is techie for 
  check all the 'write' boxes in your ftp programs' properties dialog.

- If you don't want to use a landing page (or splash page) set

	$skipLandingPage = false;

  in config.php


Now you should be up and running. If not, you're doing it wrong!

Jokes aside, if you're still having trouble, AFTER asking your techie friend 
AND your service provider AND trying to find help using Google, then you may 
contact me at nikc@iki.fi as long as you're polite.


USING
--------------------------------------

- Adding content to the gallery is easy, just upload a folder of images
  to your galleryfolder (by default, it's /assets/galleries).
- In addition to just the images, the folder should contain a file named
  info.txt. This file must in minimun contain the title for the gallery,
  but can contain some more.

  - TITLE
    - the gallery title
  - DESC
    - a description text
  - KEYW
    - keywords, not displayed anywhere, but some search engines like them
  - DATE
    - no special format required
  - THUMB
    - if you want the thumbnail to be generated from another image than the
      first image found in the folder, insert the filename here

- There is a sample info.txt provided in the sample gallery
- The gallery data is read only once per session, which might lead to you
  not seeing updates right away. You can bypass this by adding ?purge=1
  to the address bar. E.g. http://www.mygallery.com/index/?purge=1


CUSTOMIZING
--------------------------------------

- You can customize your gallery by making your own stylesheet
- You can also customize your gallery by editing the page templates.
  You find them in the templates folder.

  - landing.template.php 
    - this is the landing page
  - index.template.php
    - this is the thumbnail view
  - gallery.template.php
    - this is the gallery view

NOTE! Some of the javascript relies on a certain structure, if you change
the markup, it might be worth taking a look in 

	assets/js/global.js

There are helpful(?) comments in there.

FAQ
--------------------------------------

Q: Oops! I accidentally deleted my config.php (or other file) and my gallery
   stopped working.
A: Make a fresh install, your galleries will still be unscathed.

Q: Is this completely free?
A: Yes. Unless you really insist on giving me some money.

Q: SimpleGallery doesn't have <insert feature>
A: No, and it never will.

Q: But...
A: I said no.
