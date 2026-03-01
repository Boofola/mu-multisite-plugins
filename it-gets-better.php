<?php
/**
 * @package It_Gets_Better
 * @version 1.1.0
 */
/*
Plugin Name: It Get's Better!
Plugin URI: https://boofola.com
Description: This is just a simple plugin, it tries to give hope while you work by randomly showing inpirational quotes in the upper right of your admin screen on every page. An updated version of "Hello Dolly" by: 
Author: Todd Stratton
Version: 1.1.0
Author URI: https://boofola.com
*/

function it_gets_better_get_quotes() {
	/** These are the quotes to inspire! */
	$quotes = "Smile at strangers and you just might change a life. 
It only takes a split second to smile and forget, yet to someone that needed it, it can last a lifetime.
If you’re reading this… Congratulations, you’re alive. If that’s not something to smile about, then I don’t know what is.
Smile! It increases your face value.
No Matter What is Happening In Your Life, It Really Does Get BETTER!
Smile, it’s free therapy.
Use your smile to change the world; don’t let the world change your smile.
A smile is a curve that sets everything straight.
Today, give a stranger one of your smiles. It might be the only sunshine he sees all day.
Always find opportunities to make someone smile, and to offer random acts of kindness in everyday life.
A gentle word, a kind look, a good-natured smile can work wonders and accomplish miracles.
A warm smile is the universal language of kindness.
A smile is the universal welcome.
A smiling face is a beautiful face. A smiling heart is a happy heart.
Life is like a mirror. Smile at it and it smiles back at you.
A smile is a friend maker.
Nothing you wear is more important than your smile.
You’ll find that life is still worthwhile, if you just smile.
A smile is happiness you’ll find right under your nose.
Sometimes your joy is the source of your smile, but sometimes your smile can be the source of your joy.
A smile remains the most inexpensive gift I can bestow on anyone and yet its powers can vanquish kingdoms.
Smile, it is the key that fits the lock of everybody’s heart.
Lighten up, just enjoy life, smile more, laugh more, and don’t get so worked up about things.
One of the most rewarding things in life is to always put a smile on your face.
If you smile when you are alone, then you really mean it.
Wrinkles should merely indicate where smiles have been.
Smiling is the best way to face every problem, to crush every fear and to hide every pain.
Never regret anything that made you smile.
It’s hard not to feel happy when you make someone smile.
Anyone can smile on their best day. I like to meet a man who can smile on his WORST.
The world always looks brighter from behind a smile.
Everywhere you go, take a smile with you.
Smile more. Smiling can make you and others happy.
Learn to smile at every situation. See it as an opportunity to prove your strength and ability.";

	$quotes = explode( "\n", $quotes );

	return wptexturize( $quotes[ mt_rand( 0, count( $quotes ) - 1 ) ] );
}

function it_gets_better() {
	$chosen = it_gets_better_get_quotes();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="quotes"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Quotes to Inspire:' ),
		$lang,
		$chosen
	);
}

add_action( 'admin_notices', 'it_gets_better' );

function quotes_css() {
	echo "
	<style type='text/css'>
	#quotes {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #quotes {
		float: left;
	}
	.block-editor-page #quotes {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#quotes,
		.rtl #quotes {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'quotes_css' );
