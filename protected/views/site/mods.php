<?php $this->setPageTitle('Install the Mod'); ?>
<p>We don't recommend installing mods manually, instead, please install one our already prebuilt mods packages of the following:</p>
<ul>
    <li><a href="<?php echo $this->createUrl('site/magicDownload'); ?>">Night's Watch Minecraft Client [Windows - 1.3.2]</a></li>
    <li><a href="<?php echo $this->createUrl('site/modDownload'); ?>">Night's Watch Jar [Windows/Mac/Linux - 1.3.2]</a></li>
</ul>
<p><strong>Note:</strong></p>
<p> The Night Watch Minecraft Client currently only works for Windows. We have to rewrite all the scripts so they will also work on Mac/Linux. The version that will work on all OSs should be up in a few days. Until then, you can still use the Night's Watch Jar for Mac/Linux.</p>

<p>There are several modifications that are recommended by the Council in order to best play MineZ and for best activity within the Watch. If you wish to download them separately and install them, the list is below with links:</p>
<ul>
    <li><a href="http://www.minecraftforum.net/topic/939149-">Magic Launcher</a> - Not a Mod, the tool we're auto-packaging to make running a breeze</li>
    <li><a href="http://www.minecraftforum.net/topic/249637-">Optifine</a> - Improves Minecraft Performance</li>
    <li><a href="http://www.minecraftforum.net/topic/75440-">ModLoader</a> - A mod that helps other mods.  Most mods you install will need this.</li>
    <li><a href="http://www.minecraftforum.net/topic/482147-">Rei's Minimap</a> - Shows the miniature map that most other MineZ players use.  Allows you to set waypoints.</li>
    <li><a href="http://www.minecraftforum.net/topic/72747-">Faithful 32</a> - A 32-bit texture pack that keeps the Minecraftian feel.  Requires HD Textures.  Will work with provided JAR.</li>
    <li><a href="http://www.minecraftforum.net/topic/1438531-">FriendsOverlay</a> - An improved Friend System (our replacement for Fancy GUI - sorry about the lack of a fancy gui, though)</li>
    <li><a href="http://minez.jbakies.com/">MineZ Tactical HUD</a> - A mod that shows your armor, status effects, and arrow count on screen</li>
    <li><a href="http://www.minecapes.net/">MineCapes</a> - Set your own cape and see your friends'.</li>
    <li><a href="<?php echo Yii::app()->request->baseUrl ?>/other/nightswatch.zip">Night's Watch Mods</a> [for 1.3.2] - Adds the Night's Watch cape &amp; shows you on the live map. Also has a few compatibility fixes. Uses a custom MineCapes version.</li>
</ul>

<p><strong>Notes about using on MineZ:</strong></p>
<p>All of the above mods are currently all allowed on the MineZ servers. If you see ANYTHING about ANY of these mods not being allowed, TELL US RIGHT AWAY. We do not want to be encouraging users to use illegal mods.</p>

<p><strong>Installation Instructions</strong></p>
<p>Night's Watch Minecraft Client [Windows]</p>
<p>The Client comes build with all the above mods, including Faithful 32 and Magic Launcher. We used Magic Launcher so you can easily add other mods in or make profiles to switch between Minecraft servers easily. Upon first installing the Client, it will import all of your current Minecraft settings, world, texture packs, and mods (mods may not get installed correctly). It will also switch your texture pack to Faithful 32 on first run. Try it out! It is awesome.</p>
<ol>
	<li>Download the Night's Watch Minecraft Client</li>
	<li>Extract the files to any directory that you want</li>
	<li>Launch Minecraft.exe</li>
	<li>Enjoy!</li>
</ol>

<p>Night's Watch Minecraft Jar [Windows/Mac/Linux]</p>
<p>The Jar comes with all the above mods install, but it does not have Faithful 32 or Magic Launcher, it already has all the mods inside of the jar.</p>
<ol>
	<li>Download the Night's Watch Jar</li>
	<li>Open your File Manager (Explorer, Computer, Finder, Natuilus, etc.)</li>
	<li>Goto "%APPDATA%\.minecraft\mods"</li>
	<li>Delete or move any mods you have in this folder. The only folder left should be rei_minimap if you have it. You will have to manually figure out how to reinstall your old mods.</li>
	<li>Goto "%APPDATA%\.minecraft\bin"</li>
	<li>Put your Night's Watch Jar here and overwrite your old minecraft.jar</li>
	<li>Start Minecraft like you normally do</li>
	<li>Enjoy!</li>
</ol>

<p>Manual Installation [Windows/Mac/Linux]</p>
<p>If you do not want our prebuild mod packages, then you can make your own. Below is the recommended install order of the mods</p>
<ol>
	<li>ModLoader - ModLoader is ALWAYS first</li>
	<li>Optifine - again, Optifine is ALWAYS second</li>
	<li>Rei's Minimap</li>
	<li>FriendsOverlay</li>
	<li>MineZ Tactical HUD</li>
	<li>Night's Watch Mods** - make sure you install merge_TNW.zip LAST!!!</li>
	<li>Enjoy!</li>
</ol>
<p>**Note on using Night's Watch Mods: There are three different ZIPs in this one. You can pick which ones you want. mod_minecapes_X.X.X_TNW_vX.X.zip is our custom version of MineCapes, it gives you your Night's Watch cape. It also shows Deserters and KOS members. mod_TNWConnector.zip has our mod to communicate with our Website to tell us when you are online. This help everyone know who is online and such. Currently, only you can see yourself on the Live Map. merge_TNW.zip is compatibility fixes so all the mods play nicely. You only need the MineZ.class if you have Rei's Minimap and the MineZ Tactical HUD. You only need mod_FriendsOverlay class if you have Minecapes and FirendsOverlay installed. aow.class is only needed if you have FriendsOverlay, Rei's Minimap and MineZ Tactical HUD.</p>

<p><strong>If You Need Help:</strong></p>
<p>First, make sure your ".minecraft/mods" folder has no .ZIP files in it. If it does, we assume you know what you are doing and you are on you own. Otherwise, please goto all the threads/website for these and read all the FAQs for them and see if any of those problems cover yours. If you are still having problems and Minecraft is crashing, run Minecraft, and right AFTER it crashes, open ".minecraft/crash-reports/" and post it on <a href="http://pastebin.com">pastebin</a> and mod mail us the link and what is wrong at <a href="http://www.reddit.com/message/compose?to=%2Fr%2FTheNightsWatch">/r/TheNightsWatch</a> with what you were doing in the game to cause it to crash. There is no promise we can help fix you problems.</p>

<p><strong>Add your own mods:</strong></p>
<p>If you have any recommendations to add to this list or need help adding other mods to your own client, mod mail us on <a href="http://www.reddit.com/message/compose?to=%2Fr%2FTheNightsWatch">/r/TheNightsWatch</a> and Angellus_Mortis will help you. Note: we will NOT help you install mods that are illegal on the MineZ servers.</p>

<p><strong>Disclaimer:</strong></p>
<p>The Night's Watch did not write any of this code, nor do we own it. We are just giving it out to help our members. All the above mods are owned by the respective makers and you should go and read the forum threads for those mods if you have any problems or questions before asking us. Minecraft is owned by Mojang. All rights belong to them. Please support the original mod makers and Mojang as all of them put a lot of effort into these.</p>
