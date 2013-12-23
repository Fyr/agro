/* Smiley set for editor, in natural order.
Please try to use similar syntax in your sets, because the parser is quite sensitive.

name - smiley name (for internal use)
code - representation in text
file - representation as image
prio - priority for parsing. 1 is highest, 50 is normal. Usually smilies which may
intersect with other smilies have higher priorities over them.
lang - internationalized tip
*/
var smileSet = [
	{
		name: "smile",
		code: ":)",
		file: "smile.png",
		prio: 60,
		lang: smileL.smile
	},
	{
		name: "sad",
		code: ":(",
		file: "sad.png",
		prio: 60,
		lang: smileL.sad
	},
	{
		name: "wink",
		code: ";)",
		file: "wink.png",
		prio: 50,
		lang: smileL.wink
	},
	{
		name: "tongue",
		code: ":P",
		file: "tongue.png",
		prio: 50,
		lang: smileL.tongue
	},
	{
		name: "Cool",
		code: "8)",
		file: "cool.png",
		prio: 50,
		lang: smileL.Cool
	},
	{
		name: "biggrin",
		code: ":D",
		file: "biggrin.png",
		prio: 50,
		lang: smileL.biggrin
	},
	{
		name: "crying",
		code: ";(",
		file: "crying.png",
		prio: 50,
		lang: smileL.crying
	},
	{
		name: "rolleyes",
		code: ":rolleyes:",
		file: "rolleyes.png",
		prio: 50,
		lang: smileL.rolleyes
	},
	{
		name: "Huh",
		code: ":huh:",
		file: "huh.png",
		prio: 50,
		lang: smileL.Huh
	},
	{
		name: "unsure",
		code: ":S",
		file: "unsure.png",
		prio: 50,
		lang: smileL.unsure
	},
	{
		name: "love",
		code: ":love:",
		file: "love.png",
		prio: 50,
		lang: smileL.love
	},
	{
		name: "angry",
		code: "X(",
		file: "angry.png",
		prio: 50,
		lang: smileL.angry
	},
	{
		name: "blink",
		code: "8|",
		file: "blink.png",
		prio: 50,
		lang: smileL.blink
	},
	{
		name: "confused",
		code: "?(",
		file: "confused.png",
		prio: 50,
		lang: smileL.confused
	},
	{
		name: "cursing",
		code: ":cursing:",
		file: "cursing.png",
		prio: 50,
		lang: smileL.cursing
	},
	{
		name: "mellow",
		code: ":|",
		file: "mellow.png",
		prio: 50,
		lang: smileL.mellow
	},
	{
		name: "thumbdown",
		code: ":thumbdown:",
		file: "thumbdown.png",
		prio: 50,
		lang: smileL.thumbdown
	},
	{
		name: "thumbsup",
		code: ":thumbsup:",
		file: "thumbsup.png",
		prio: 50,
		lang: smileL.thumbsup
	},
	{
		name: "thumbup",
		code: ":thumbup:",
		file: "thumbup.png",
		prio: 50,
		lang: smileL.thumbup
	},
	{
		name: "w00t",
		code: "8o",
		file: "w00t.png",
		prio: 50,
		lang: smileL.w00t
	},
	{
		name: "pinch",
		code: ":pinch:",
		file: "pinch.png",
		prio: 50,
		lang: smileL.pinch
	},
	{
		name: "sleeping",
		code: ":sleeping:",
		file: "sleeping.png",
		prio: 50,
		lang: smileL.sleeping
	},
	{
		name: "wacko",
		code: ":wacko:",
		file: "wacko.png",
		prio: 50,
		lang: smileL.wacko
	},
	{
		name: "whistling",
		code: ":whistling:",
		file: "whistling.png",
		prio: 50,
		lang: smileL.whistling
	},
	{
		name: "evil",
		code: ":evil:",
		file: "evil.png",
		prio: 50,
		lang: smileL.evil
	},
	{
		name: "squint",
		code: "^^",
		file: "squint.png",
		prio: 50,
		lang: smileL.squint
	},
	{
		name: "attention",
		code: ":!:",
		file: "attention.png",
		prio: 50,
		lang: smileL.attention
	},
	{
		name: "question",
		code: ":?:",
		file: "question.png",
		prio: 50,
		lang: smileL.question
	}
];

// Editor dialog display properties
var smileBox = {
	width: '210px',
	height: '170px',
	perRow: 4 // Smilies per row
};