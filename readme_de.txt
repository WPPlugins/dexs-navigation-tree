=== Dexs Navigation Tree ===
Contributors: sambrishes
Donate link: http://www.gofundme.com/81q7rg
Tags: table, of, contents, navigation, tree, widget, table of contents, content, index, links, navi, sitemap, site, map, toc, sidebar
Requires at least: 3.8
Tested up to: 4.0.1
Stable tag: 1.2.2
License: MIT License
License URI: http://opensource.org/licenses/MIT

Dieses Plugin erstellt ein Inhaltsverzeichnis, dass Du direkt über einen Shortcode sowie über das eigene Widget anzeigen lassen kannst!

== Description ==
Das Dexs Navigation Tree Plugin erstellt ein kleines Inhaltsverzeichnis, dass Du mithife des 
Shortcodes `[dexs_toc]` sowie über das eigene Sidebar Widget anzeigen lassen kannst!

Du kannst ein Standard-Design für alle Inhaltsverzeichnisse über die Administrationsseite, 
'Dexs Navigation Tree' unter 'Einstellungen', erstellen! Es ist jedoch auch mögich jedes 
Inhaltsverzeichnis für sich selbst zu designen, nutze hierfür den "Shortcode generieren" Button auf 
der Adminseite oder lies dir den FAQ Bereich durch!

= So funktioniert es! =
Das Plugin generiert automatisch eine Inhaltsverzeichnisliste mithilfe the Content Kopfelemente h1 - 
h6. Du kannst jedoch auch eigene Listen mithilfe der Klassennamen anchor-1 bis anchor-6 erstellen, 
füge diese lediglich in ein span, p, div, i, b, strong oder section Element ein. (Siehe FAQ)

= Neu in Version 1.2.2 =
*	Rückwärstkompatibel bis zu PHP 5.2.4
*	Einige Fehlerbehebungen

= Neu in Version 1.2.0 =
*	Eine eigene Administrations Seite mitsamt einem Shortcode Generator
*	Die Möglichkeit den Beitragstitel als ersten Listen-Eintrag zu setzen
*	Ein paar weitere Einstellungsmöglichkeiten

Weitere Informationen unter "Changelog".

= Funktionen =
*	Ein Shortcode für deine Beiträge und Seiten
*	Ein Widget für deine Sidebar
*	Viele Design-Optionen mit 4 Auflistungsstilen
*	Eine optionale Anker-Verlinkung
*	Sprachen: Englisch und Deutsch

= Demo =
Gehe für eine volle Demonstration auf [unsere Webseite](http://www.pytes.net/demo/dexs-navigation-tree "www.pytes.net")!

= Danke an =
*	[Brendan Kidwell](https://profiles.wordpress.org/bkidwell "Seine WordPress.org-Seite") für den [Fehlerbericht](https://wordpress.org/support/topic/does-not-work-on-php-52 "Zum Fehlerbericht").
*	[CieNTi](https://wordpress.org/support/profile/cienti "Seine WordPress.org-Seite") für den Fehlerbericht (via Mail).
*	[Deadpool](https://profiles.wordpress.org/deadpool13 "Seine WordPress.org-Seite") für den [Fehlerbericht](https://wordpress.org/support/topic/nothing-displaying-2 "Zum Fehlerbericht") und die Beitragstitel-Idee.
== Installation ==
1.	Lade den `dexs-navigation-tree` Ordner in dein `/wp-content/plugins/` Verzeichnis hoch
1.	Aktiviere das Plugin über das "Plugins" Menu in WordPress
1.	Füge das `Inhaltsverzeichnis` widget zu deiner Sidebar hinzu ODER
1.	schreibe den `[dexs_toc]` Shortcode auf jeden Beitrag und jede Seite.

== Screenshots ==
1.	Die Standard Inhaltsverzeichnis-Designs, getestet mit unserem Template
2.	Die Standard Inhaltsverzeichnis-Designs, getestet mit demo Twenty Fourteen Template.
3.	Die Administrationsseite sowie die Widget Einstellungen.

== Changelog ==
= 1.2.2 =
*	Update: Die "content-catch" Funktion
*	Update: Rückwärtskompatibel zu PHP Version 5.2.4
*	Bugfix: Ein paar Render und wpautop Fehler
*	Bugfix: Ein Preg Match Fehler innerhalb der eigenen TOC Verlinkung
*	Bugfix: Dashicon-Font Fehler in WordPress Version 3.8
*	Entfernt: Der eigene "add_toc_container" filter

= 1.2.1 =
*	Info:	Getested mit dem [WP Markdown Live](https://wordpress.org/plugins/wp-markdown-live/) Plugin.
*	Update:	Die Priorität des "the_content" Filters wurde auf 15 erhöht
*	Update:	Der "the_content" Filter wurde zur TOC PHP-Klasse verschoben.
*	Bugfix:	Deutsche Sprachausgabe

= 1.2.0 =
*	Neu: Eine neue PHP System Klasse (Das Widget wurde zur System Klasse verschoben)
*	Neu: Eine Administrations-Seite mit einem JS Shortcode Generator
*	Neu: Weitere Einstellungsmöglich#eiten
*	Update: Das Widget
*	Update:	Das Design des Inhaltsverzeichnis
*	Update:	Das Rendering des Inhaltsverzeichnis
*	Entfernt: Die Beitrag / Seiten Einschränkung
*	Entfernt: Die "Anchor Above" (Springe über den Titel) Option
*	Entfernt: Das Ordner-Icon (Die Dashicon-Font wird absofort genutzt)

= 1.1.0 =
*	Neu: Eine Shortcode Funktion für Beiträge und Seiten
*	Update: Die Plugin Beschreibung
*	Update:	Die CSS Datei
*	Update:	Das PHP Klassensystem
*	Bugfix:	Die fehlerhafte Auflistung

= 1.0.0 =
*	Erste stabile Version

== Frequently Asked Questions == 
= Wie nutze ich es? =
Schreibe den folgenden Shortcode als erste Zeile in jeden Beitrag und jede Seite. Und vergiss nicht: Der Shortcode muss auch
nach JEDER &lt;!--nextpage--&gt; Anweisung als erstes hinzugefügt werden, sofern du das Inhaltsverzeichnis auf jeder Seite einfügen willst.

`[dexs_toc]`

UND/ODER verschiebe das "Inhaltsverzeichnis" - Widget zu deiner Sidebar.

= Wie designe ich es? =
Nutze den Shortcode Generator auf der Administrationsseite ('Einstellungen' -> 'Dexs Navigation Tree') oder nutze folgende Attribute innerhalb des *[dexs_toc]* Shortcodes:

**Neu in 1.2.0**

`type="h"`
*	Optionen: "h" | "c"
*	Info: Ändert das Content Rendering (Siehe "Wie steuer ich es?" für weitere informationen.)

`post_title=true`
*	Optionen: true | false
*	Info: Nutze den Beitragstitel als erstes Element.

`post_sub=false`
*	Optionen: true | false
*	Info: Ordner sämtliche kommenden Elemente unter den Beitragstitel

`colors="default,default,default"`
*	Optionen: "font,link,link:hover"
*	Info: Konfiguriere die Farben wie oben angegeben

`css=""`
*	Info: Füge eigene CSS Codes hinzu

**Since 1.1.0**

`title="Table of Contents"`
*	Info: Ändere den Titel

`align="right"`
*	Optionen: "right" | "left" | "none" | "center"
*	Info: Ändere die Position des Containers

`anchor=true`
*	Optionen: true | false
*	Info: De/Aktiviere die Anker-Verlinkung

`tag="ul"`
*	Optionen: "ul" | "ol"
*	Info: Ändere das HTML Listen-Element

`design="level_num"`
*	Optionen: "num" | "level_num" | "folder" | "folder_num"
*	Info: Ändere den Auflistungs-Stil

`border="1px solid #d0d0d0"`
*	Optionen: "width style color"
*	Info: Ändere die Umrandung des Containers

`background="transparent"`
*	Optionen: "color"
*	Info: Ändere den Hintergrund des Containers

= How steuer ich es? =
Seit Version 1.2.0 hast du 2 Möglichkeiten:

**Möglichkeit 1: Kopf Elemente**

Nutze die Content-Kopf Elmentelt;h1&gt; - &lt;h6&gt; (Du musst nicht mit &lt;h1&gt; starten).

*Beispiel*
`[dexs_toc type="h"]
&lt;h1&gt;Titel 1&lt;/h1&gt;
&lt;h2&gt;Titel 2&lt;/h2&gt;`

**Möglichkeit 2: Klassennamen**

Nutze die Klassennamen "anchor-1" bis zu "anchor-6" innerhalb eines &lt;span&gt;, &lt;p&gt;, &lt;div&gt;, &lt;i&gt;, &lt;b&gt;, &lt;strong&gt; oder 
&lt;section&gt; Elements. So kannst du den Titel der im Inhaltsverzeichnis erscheint auch manipulieren.

PS.: Das Element mit der "anchor-*" Klasse wird entfernt, also füge nie mehr als den Titel ein!

*Beispiel*
`[dexs_toc type="c"]
&lt;span class="anchor-1"&gt;Mein erster Titel&lt;/span&gt;
&lt;h1&gt;Mein erster Beitragstitel&lt;/h1&gt;
&lt;span class="anchor-1"&gt;Mein zweiter Titel&lt;/span&gt;
&lt;h1&gt;Mein zweiter Beitragstitel&lt;/h1&gt;`

= Wie funktioniert das Widget? =
Das Widget erscheint auf jeder Seite sowie jedem Beitrag (is_page() && is_post()). Du kannst aber mihilfe des 
[Widget Logic](https://wordpress.org/plugins/widget-logic "WordPress.org Plugin Link") WordPress Plugin auch selbst bestimmen wo das Plugin 
angezeigt werden soll und wo nicht.

== Upgrade Notice ==
Nope
