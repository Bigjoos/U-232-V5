<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
$lang = array(
    //TAGS
    'tags_description' => "Description:",
    'tags_systax' => "Syntax:",
    'tags_example' => "Example:",
    'tags_result' => "Result:",
    'tags_remarks' => "Remarks:",
    'tags_tags' => "Tags",
    'tags_title' => "<p>The {$INSTALLER09['site_name']} forums supports a number of <i>BB tags</i> which you can embed to modify how your posts are displayed.</p>",
    'tags_test' => "Test this code!",
    'tags_bold1' => "Bold",
    'tags_bold2' => "Makes the enclosed text bold.",
    'tags_bold3' => "[b]<i>Text</i>[/b]",
    'tags_bold4' => "[b]This is bold text.[/b]",
    'tags_italic1' => "Italic",
    'tags_italic2' => "Makes the enclosed text italic.",
    'tags_italic3' => "[i]<i>Text</i>[/i]",
    'tags_italic4' => "[i]This is italic text.[/i]",
    'tags_underline1' => "Underline",
    'tags_underline2' => "Makes the enclosed text underlined.",
    'tags_underline3' => "[u]<i>Text</i>[/u]",
    'tags_underline4' => "[u]This is underlined text.[/u]",
    'tags_color1' => "Color (alt. 1)",
    'tags_color2' => "Changes the color of the enclosed text.",
    'tags_color3' => "[color=<i>Color</i>]<i>Text</i>[/color]",
    'tags_color4' => "[color=blue]This is blue text.[/color]",
    'tags_color5' => "What colors are valid depends on the browser. If you use the basic colors (red, green, blue, yellow, pink etc) you should be safe.",
    'tags_color6' => "Color (alt. 2)",
    'tags_color7' => "Changes the color of the enclosed text.",
    'tags_color8' => "[color=#<i>RGB</i>]<i>Text</i>[/color]",
    'tags_color9' => "[color=#0000ff]This is blue text.[/color]",
    'tags_color10' => "<i>RGB</i> must be a six digit hexadecimal number.",
    'tags_size1' => "Size",
    'tags_size2' => "Sets the size of the enclosed text.",
    'tags_size3' => "[size=<i>n</i>]<i>text</i>[/size]",
    'tags_size4' => "[size=4]This is size 4.[/size]",
    'tags_size5' => "<i>n</i> must be an integer in the range 1 (smallest) to 7 (biggest). The default size is 2.",
    'tags_fonts1' => "Font",
    'tags_fonts2' => "Sets the type-face (font) for the enclosed text.",
    'tags_fonts3' => "[font=<i>Font</i>]<i>Text</i>[/font]",
    'tags_fonts4' => "[font=Impact]Hello world![/font]",
    'tags_fonts5' => "You specify alternative fonts by separating them with a comma.",
    'tags_hyper1' => "Hyperlink (alt. 1)",
    'tags_hyper2' => "Inserts a hyperlink.",
    'tags_hyper3' => "[url]<i>URL</i>[/url]",
    'tags_hyper4' => "[url]" . $INSTALLER09['baseurl'] . "/[/url]",
    'tags_hyper5' => "This tag is superfluous; all URLs are automatically hyperlinked.",
    'tags_hyper6' => "Hyperlink (alt. 2)",
    'tags_hyper7' => "Inserts a hyperlink.",
    'tags_hyper8' => "[url=<i>URL</i>]<i>Link text</i>[/url]",
    'tags_hyper9' => "[url=" . $INSTALLER09['baseurl'] . "/]" . $INSTALLER09['site_name'] . "[/url]",
    'tags_hyper10' => "You do not have to use this tag unless you want to set the link text; all URLs are automatically hyperlinked.",
    'tags_image1' => "Image (alt. 1)",
    'tags_image2' => "Inserts a picture.",
    'tags_image3' => "[img=<i>URL</i>]",
    'tags_image4' => "[img=" . $INSTALLER09['baseurl'] . "/pic/logo.gif]",
    'tags_image5' => "The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>.",
    'tags_image6' => "Image (alt. 2)",
    'tags_image7' => "Inserts a picture.",
    'tags_image8' => "[img]<i>URL</i>[/img]",
    'tags_image9' => "[img]" . $INSTALLER09['baseurl'] . "/pic/logo.gif[/img]",
    'tags_image10' => "The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>.",
    'tags_quote1' => "Quote (alt. 1)",
    'tags_quote2' => "Inserts a quote.",
    'tags_quote3' => "[quote]<i>Quoted text</i>[/quote]",
    'tags_quote4' => "[quote]The quick brown fox jumps over the lazy dog.[/quote]",
    'tags_quote5' => "Quote (alt. 2)",
    'tags_quote6' => "Inserts a quote.",
    'tags_quote7' => "[quote=<i>Author</i>]<i>Quoted text</i>[/quote]",
    'tags_quote8' => "[quote=John Doe]The quick brown fox jumps over the lazy dog.[/quote]",
    'tags_list1' => "List",
    'tags_list2' => "Inserts a list item.",
    'tags_list3' => "[*]<i>Text</i>",
    'tags_list4' => "[*] This is item 1\n[*] This is item 2",
    'tags_preformat1' => "Preformat",
    'tags_preformat2' => "Preformatted (monospace) text. Does not wrap automatically.",
    'tags_preformat3' => "[pre]<i>Text</i>[/pre]",
    'tags_preformat4' => "[pre]This is preformatted text.[/pre]",
);
?>