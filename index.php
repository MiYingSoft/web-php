<?php
/*
   If you're reading this, it isn't because you've found a security hole.
   this is an open source website. read and learn!
*/

/* ------------------------------------------------------------------------- */

// Get the modification date of this PHP file
$timestamps[] = @getlastmod();

/*
   The date of prepend.inc represents the age of ALL
   included files. Please touch it if you modify any
   other include file (and the modification affects
   the display of the index page). The cost of stat'ing
   them all is prohibitive. Also note the file path,
   we aren't using the include path here.
*/
$timestamps[] = @filemtime("include/prepend.inc");

// Calendar is the only "dynamic" feature on this page
$timestamps[] = @filemtime("include/pregen-events.inc");

// The latest of these modification dates is our real Last-Modified date
$timestamp = max($timestamps);

// Note that this is not a RFC 822 date (the tz is always GMT)
$tsstring = gmdate("D, d M Y H:i:s ", $timestamp) . "GMT";

// Check if the client has the same page cached
if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) &&
    ($_SERVER["HTTP_IF_MODIFIED_SINCE"] == $tsstring)) {
    header("HTTP/1.1 304 Not Modified");
    exit();
}
// Inform the user agent what is our last modification date
else {
    header("Last-Modified: " . $tsstring);
}

$_SERVER['BASE_PAGE'] = 'index.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/prepend.inc';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/pregen-events.inc';

// This goes to the left sidebar of the front page
$SIDEBAR_DATA = '
<h3>What is PHP?</h3>
<p>
 <acronym title="recursive acronym for PHP: Hypertext Preprocessor">PHP</acronym>
 is a widely-used general-purpose scripting language that is
 especially suited for Web development and can be embedded into HTML.
 If you are new to PHP and want to get some idea
 of how it works, try the <a href="/tut.php">introductory tutorial</a>.
 After that, check out the online <a href="/docs.php">manual</a>,
 and the example archive sites and some of the other resources
 available in the <a href="/links.php">links section</a>.
</p>
<p>
 Ever wondered how popular PHP is? see the
 <a href="/usage.php">Netcraft Survey</a>.
</p>
<p>
 PHP is a project of the
 <a href="http://www.apache.org/">Apache Software Foundation</a>.
</p>

<h3><a href="/thanks.php">Thanks To</a></h3>
<ul class="simple">
 <li><a href="http://www.easydns.com/?V=698570efeb62a6e2">easyDNS</a></li>
 <li><a href="http://www.directi.com/">Directi</a></li>
 <li><a href="http://promote.pair.com/direct.pl?php.net">pair Networks</a></li>
 <li><a href="http://www.ev1servers.net/">EV1Servers</a></li>
 <li><a href="http://www.servercentral.net/">Server Central</a></li>
 <li><a href="http://www.redundant.com/">Redundant Networks</a></li>
 <li><a href="http://www.simplicato.com/?a=1007">Simplicato</a></li>
 <li><a href="http://www.rackspace.com/?supbid=php.net">Rackspace</a></li>
</ul>
<h3>Related sites</h3>
<ul class="simple">
 <li><a href="http://www.apache.org/">Apache</a></li>
 <li><a href="http://www.mysql.com/">MySQL</a></li>
 <li><a href="http://www.postgresql.org/">PostgreSQL</a></li>
 <li><a href="http://www.zend.com/">Zend Technologies</a></li>
</ul>
<h3>Community</h3>
<ul class="simple">
 <li><a href="http://www.linuxfund.org/">LinuxFund.org</a></li>
 <li><a href="http://www.osdn.org/">OSDN</a></li>
</ul>

<h3>Syndication</h3>
<p>
 You can grab our news as an RSS feed via a daily dump in a file
 named <a href="/news.rss">news.rss</a>.
</p>';

$MIRROR_IMAGE = '';

// Iterate through possible mirror provider logo types in priority order
$types = array("gif", "jpg", "png");
while (list(,$ext) = each($types)) {

    // Check if file exists for this type
    if (file_exists("backend/mirror." . $ext)) {

        // Add text to rigth sidebar
        $MIRROR_IMAGE = "<div align=\"center\"><h3>This mirror sponsored by:</h3>\n";

        // Create image HTML code
        $img = make_image(
            'mirror.' . $ext,
            htmlspecialchars(mirror_provider()),
            FALSE,
            FALSE,
            'backend',
            0
        );

        // Add size information depending on mirror type
        if (is_primary_site() || is_backup_primary()) {
            $img = resize_image($img, 125, 125);
        } else {
            $img = resize_image($img, 120, 60);
        }

        // End mirror specific part
        $MIRROR_IMAGE .= '<a href="' . mirror_provider_url() . '">' .
                         $img . "</a></div><br /><hr />\n";

        // We have found an image
        break;
    }
}

// Prepend mirror image to sidebar text
$RSIDEBAR_DATA = $MIRROR_IMAGE . $RSIDEBAR_DATA;

// Run the boldEvents() function on page load
$ONLOAD = "boldEvents(); searchHistory();";

// Write out common header
commonHeader("Hypertext Preprocessor");

// DO NOT REMOVE THIS COMMENT (the RSS parser is dependant on it)
?>

<h1>PHP 4.3.5RC1 released!</h1>
<p>
 <span class="newsdate">[12-Jan-2004]</span>
 <a href="http://qa.php.net/">PHP 4.3.5RC1</a> has been released for testing. This is the 
 first release candidate and should have a very low number of problems and/or bugs. 
 Nevertheless, please download and test it as much as possible on real-life applications 
 to uncover any remaining issues. List of changes can be found in the 
 <a href="http://cvs.php.net/diff.php/php-src/NEWS?login=2&r1=1.1247.2.452&r2=1.1247.2.522">NEWS</a> file.
</p>

<hr />

<?php news_image("http://www.pawscon.com/", "paws_small.jpg", "PHP and Web Standards Conference - UK 2004"); ?>

<h1>PHP and Web Standards Conference - UK 2004</h1>
<p>
 <span class="newsdate">[22-Dec-2003]</span>
 Call for Papers: PHP and Web Standards Conference - UK 2004<br />
 The PaWS Group is pleased to announce the first ever UK <a
 href="http://www.pawscon.com">PHP and Web Standards Conference</a>.
 PaWS Con will cover using PHP and Web Standards separately and in
 conjunction with each other. The conference will take place
 from February 20th - 24th 2004.
</p>
<p>
 The <a href="http://www.pawscon.com/speakers">Call for Papers</a> has
 been announced with a deadline of January 17th.
 <a href="http://www.pawscon.com/register">Pre-Registration</a> for
 early-bird savers is now also open, so register to earn your
 discount and provide PaWS with valuable feedback.
</p>

<hr />

<?php news_image("http://vancouver.php.net/", "vancouver_conference_2004.gif", "Vancouver PHP Conference 2004"); ?>

<h1>Vancouver PHP Conference 2004</h1>
<p>
 <span class="newsdate">[22-Dec-2003]</span>
 The Vancouver PHP Users Association presents <a href="http://vancouver.php.net/">The PHP Vancouver Conference</a>
 on January 22-23, a professional and technical conference focused on the PHP scripting language.
 The goal of this conference is to bring together some of the world's leading PHP developers and
 business professionals to share their experience with both students and PHP professionals in a series of talks.</p>
<hr />

<h1>PHP 5.0 Beta 3 released!</h1>
<p>
 <span class="newsdate">[21-Dec-2003]</span>
 <a href="/downloads.php">PHP 5.0 Beta 3</a> has been released.  The third beta of PHP is also scheduled
 to be the last one (barring unexpected surprises).  This beta incorporates
 dozens of bug fixes since Beta 2, better XML support and many other
 improvements, some of which are documented in the <a href="/ChangeLog-5.php#5.0.0b3">ChangeLog</a>.
</p>
<p>
 Some of the key features of PHP 5 include:
</p>
<ul>
 <li>
  PHP 5 features the <a href="/zend-engine-2.php">Zend Engine 2</a>.
 </li>
 <li>
  XML support has been completely redone in PHP 5, all extensions are now focused around the
  excellent libxml2 library (<a href="http://www.xmlsoft.org/">http://www.xmlsoft.org/</a>).
 </li>
 <li>
  SQLite has been bundled with PHP. For more information on SQLite, please visit their
  <a href="http://www.hwaci.com/sw/sqlite/">website</a>.
 </li>
 <li>
  A new SimpleXML extension for easily accessing and manipulating XML as PHP objects. It can
  also interface with the DOM extension and vice-versa.
 </li>
 <li>
  Streams have been greatly improved, including the ability to access low-level socket
  operations on streams.
 </li>
</ul>

<hr />

<h1>PHP Community Site Project Announced</h1>
<p>
 <span class="newsdate">[18-Dec-2003]</span>
 Members of the PHP community are <a href="http://shiflett.org/archive/19">seeking
 volunteers</a> to help develop the first Web site that is created both by
 the community and for the community. The features of this project will be
 driven by the needs and desires of the community as much as possible and
 may include such things as blogs, news, FAQs, articles, links, and tutorials.
</p>
 <p>
 If you would like to contribute, please <a
 href="http://shiflett.org/contact">contact Chris Shiflett</a>, who is
 coordinating this project. There is a need for every type of contributor,
 including developers, translators, administrators, designers, writers, and
 advocates.
</p>

<hr />

<?php news_image("http://www.php-mag.net/", "php-mag.gif", "International PHP Magazine"); ?>

<h1>PHP Magazine in PDF Format</h1>
<p>
 <span class="newsdate">[15-Dec-2003]</span>
 <a href="http://software-support.biz/en">Software & Support Media</a>,
 producers of the <a href="http://www.phpconference.de/2003/index_en.php">International
 PHP Conference</a>, are pleased to announce a new monthly version of their
 print publication, the "<a href="http://www.php-mag.net/">International
 PHP Magazine</a>", published in PDF format and distributed
 electronically. The first issue is available for free on
 <a href="http://www.php-mag.net/">the magazine's website</a>.
</p>

<hr />

<?php news_image("http://conf.phpquebec.org/index.html", "conference_php_quebec.gif", "Conference PHP Quebec"); ?>

<h1>First PHP dedicated DVD released!</h1>
<p>
 <span class="newsdate">[13-Dec-2003]</span>
 The PHP Qu&eacute;bec is pleased to announce the immediate availability
 of PHP Qu&eacute;bec DVD. Over 6 hours of conferences, recorded in
 Montr&eacute;al, in March 2003. DVD is subtitled in English and French,
 making legendary sessions from Rasmus and Zeev available anywhere 
 in the world. 
</p>
<p> 
 This DVD makes a nice christmas present for every PHP enthusiast.
 Available in
 <a href="http://conf.phpquebec.org/main.php/en/dvd2003/main">English</a> or 
 <a href="http://conf.phpquebec.org/main.php/fr/dvd2003/main">French</a>.
</p>

<hr />

<?php news_image("http://mysql.com/events/uc2004", "mysqluc2004.png", "MySQL User Conference 2004"); ?>

<h1>Call for Participation: MySQL User Conference 2004</h1>
<p>
 <span class="newsdate">[12-Dec-2003]</span>
 The <a href="http://mysql.com/events/uc2004/speakers.html">Call
 for Participation</a> for the 2004 MySQL User Conference is
 now open. MySQL is looking for sessions that speak to your peers:
 practical, pragmatic and clueful presentations that focus on how
 you solved problems in a demanding or unique technical environment.
 Additionally, the conference is looking for solid proposals for
 Bird-of-a-Feather (BoF) sessions and Lightning Talks.
</p>
<p>
 The call for papers closes on January 14th. The call for BoFs and
 lightning talks closes on February 14th. The conference will take
 place on April 14th to 16th in Orlando, Florida, USA.
</p>

<hr />

<?php news_image("http://www.phpconference.com/", "intcon2004spring.png", "International PHP Conference 2004 - Spring Edition"); ?>

<h1>Call for Papers: PHP Conference 2004 - Spring Edition</h1>
<p>
 <span class="newsdate">[10-Dec-2003]</span>
 The organizers of the International PHP Conference are proud
 to announce the second edition of the Intl PHP Conference 2004
 Spring Edition in Amsterdam. Again, we'll meet at the RAI Conference
 Center for three days: one day with hands-on power workshops and
 two days main conference. The conference will happen from May, 3rd
 to May, 5th 2004.
</p>
<p>
 The <a href="http://www.phpconference.com/">call for papers</a> has
 been announced now. Just submit your sessions at <a 
 href="http://www.phpconference.de/kt/input/">http://www.phpconference.de/kt/input/</a> -
 they'll be reviewed by the Chair Board which consists this year of:
 Bj&ouml;rn Schotte (chair), Zak Greant, Derick Rethans, George
 Schlossnagle, and Sascha Schumann. The full conference website will
 be online soon.
</p>

<hr />

<?php news_image("http://webdevmagazine.co.uk/conf/index_n.php", "bulgaria_2004.gif", "First Bulgarian PHP conference"); ?>

<h1>First Bulgarian and Second Hungarian PHP Conference</h1>
<p>
 <span class="newsdate">[01-Dec-2003]</span>
 The <a href="http://webdevmagazine.co.uk/conf/index_n.php">First Bulgarian
 PHP conference</a> will be held within the framework of the 2004 Web Technology
 Conference in Sofia in March. The goal of the meeting is to discuss the trends and
 to popularize PHP among the business, education and services sectors. The organizers
 welcome proposals for sessions and company presentations.
</p>

<?php news_image("http://www.phpconf.hu/", "hu_conf.gif", "Second Hungarian PHP conference"); ?>

<p>
 Also coming in March 2004 is the <a href="http://www.phpconf.hu/">Second Hungarian
 PHP Conference</a> building on last year's successful event. The Call For Papers is
 open for the conference, speakers are welcome to hold sessions and workshops ranging
 from PHP internals to web standard compliance. The event is exclusively in Hungarian.
</p>

<hr />

<?php news_image("http://conf.phpquebec.org/index.html", "conference_php_quebec.gif", "Conference PHP Quebec"); ?>

<h1>Call for Speakers: PHP Qu&eacute;bec 2004</h1>
<p>
 <span class="newsdate">[11-Nov-2003]</span>
 The PHP Qu&eacute;bec is pleased to announce the PHP Qu&eacute;bec 
 conference 2004, which will be held on March, 25th&amp;26th 2004. 
 We are looking for the best speakers, willing to 
 share their experience and skills with the educated crowd of PHP 
 programmers in eastern Canada and in the USA. PHP Qu&eacute;bec 
 2004 features 3 distinct tracks:
 <ul>
  <li>
   Professional PHP, dealing with php usage in professional 
   environment and unusual businesses.
  </li>
  <li>
   Technical PHP, covering indeep details of PHP technics.
  </li>
  <li>
   Free software, about any free software, closely related to PHP.
  </li>
 </ul>
 <a href="http://conf.phpquebec.com/">Sessions</a> will be held in
 <a href="http://conf.phpquebec.com/main.php/fr/accueil/main">French</a> or 
 <a href="http://conf.phpquebec.com/main.php/en/accueil/main">English</a>.
 For more information, read the <a 
 href="http://conf.phpquebec.org/main.php/en/conf2004/conferencier">PHP Qu&eacute;bec</a>.
</p>

<hr />

<h1>New function list auto completion</h1>
<p>
 <span class="newsdate">[04-Nov-2003]</span>
 You can probably name at least one IDE providing support for PHP function name
 code completion. PHP.net is just <em>beta testing</em> the same feature
 <a href="/search.php">on the search page</a>. Try selecting the 'function
 list' lookup option and start typing in a function name in the search field.
 You can autocomplete the name with the space key and navigate in the dropdown
 with the up and down cursor keys. We welcome feedback on this feature at
 <a href="/copyright.php#contact">the webmasters email address</a>, but
 please submit any bugs you find <a href="http://bugs.php.net/">in the
 bug system</a> classifying them as a "PHP.net website problem" and providing 
 as much information as possible (OS, Browser version, Javascript errors, etc..).
</p>

<hr />

<h1>PHP 4.3.4 released!</h1>
<p>
 <span class="newsdate">[03-Nov-2003]</span>
 The PHP developers are proud to announce the immediate availability of
 <a href="release_4_3_4.php">PHP 4.3.4</a>. This release contains a fair
 number of bug fixes and we recommend that all users of PHP upgrade to 
 this version. Full list of fixes can be found in the 
 <a href="ChangeLog-4.php#4.3.4">ChangeLog</a>.
</p>

<hr />

<p class="center"><a href="/news-2003.php">News Archive</a></p>

<?php commonFooter(); ?>
