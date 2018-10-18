<?php
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
error_reporting(E_ERROR | E_PARSE);

// $mysql = new mysqli ( 'puajivlwuajo.rds.sae.sina.com.cn', 'obird', 'Java19786028', 'zstock', '12648' );
// $mysql = new mysqli('localhost', 'root', '19786028', 'congshi');
//public internet
$mysql = new mysqli('rm-bp149hof32gt0cewt7o.mysql.rds.aliyuncs.com', 'ichess', 'Java19786028', 'ichess');
//private network
//$mysql = new mysqli('rm-bp149hof32gt0cewt.mysql.rds.aliyuncs.com', 'ichess', 'Java19786028', 'ichess');
if (! $mysql)
    die("connect error:" . mysqli_connect_error());
$mysql->set_charset("utf8");

$icode = 'sz399001';
$ycode = '399001.sz';

$candidate = 'sh601288,sh601166,sh601398,sh601939,sh601818,sh601988,sh600016,sh600100,sh600015,sh600129,sh601328,sh600000,sz000001,sh601169,sz000625,sh600036,sh601998,sz000600,sh600177,sh600730,sh601009,sh601668,sh601318,sh600029,sz002142,sh600741,sh600048,sz000966,sz000069,sz002146,sh600718,sh600104,sh600023,sz000150,sh600026,sh601229,sh600027,sh600350,sh600823,sh600894,sh601997,sh600919,sh601633,sh600674,sh600366,sh600886,sh601107,sh600064,sz000900,sz000488,sh600642,sz000540,sh600688,sh600115,sz000059,sh601155,sh600236,sz000543,sh600269,sh601872,sz000876,sz300498,sz002714,sz000541,sh600011,sh600020,sz000651,sh600221,sh600926,sh600340,sz000933,sz000883,sz000333,sh601111,sh600826,sh600606,sz000926,sh600004,sz002210,sz001896,sz000732,sz000581,sz000936,sh600060,sh600795,sz000531,sz002157,sh600240,sh600900,sh600694,sh600033,sh600690,sz000501,sh600755,sh600585,sh600377,sz000667,sh601211,sz000539,sh600724,sh600717,sz000601,sz300632,sz000726,sz002147,sh600641,sh600835,sz002394,sz000537,sh600398,sz000036,sh601186,sh600987,sh601669,sh600507,sz000429,sh601006,sz300118,sz002092,sh600066,sh601000,sh600089,sz000957,sh603188,sz002202,sz000776,sh600352,sh600270,sz000030,sh600742,sz002244,sh600548,sh600285,sz000623,sh600052,sz002477,sh600170,sz000685,sh601992,sh600537,sh601088,sz000921,sh601390,sh600816,sh600309,sz000055,sh600273,sz002078,sz000902,sz002701,sh600684,sz002458,sz000895,sh600176,sh600578,sz002083,sh600897,sz002128,sz002081,sz000587,sh601098,sz002563,sz000828,sh603167,sh600028,sz000899,sh600660,sh601339,sz000916,sz002001,sz000719,sh600153,sh603885,sz001979,sh600299,sh600068,sh600704,sh600600,sz002110,sz002267,sz002440,sh600757,sh601688,sh601021,sh600030,sh600483,sh600075,sh600426,sh600418,sh601377,sz000550,sh600297,sh601607,sz002493,sh600019,sh600094,sz000786,sh600098,sz000027,sh600312,sh600598,sz000698,sz002327,sz002048,sh600018,sz000046,sh600790,sh600697,sz002504,sh600887,sz000863,sz002597,sh601636,sh600039,sh600376,sh600461,sh600009,sh600061,sz000598,sh600975,sh603369,sh601800,sh601336,sz000708,sh600230,sh600612,sz000718,sh600162,sh601012,sh601601,sz000031,sh600509,sh600438,sz000958,sh600999,sh600346,sh600675,sh600978,sz002051,sh603766,sh600508,sz000100,sh600383,sz002285,sh600565,sz002003,sz002242,sh600665,sz000002,sh600323,sh600837,sz002294,sh600891,sz000686,sz002662,sh600859,sh600216,sh600167,sh600120,sh600409,sz002027,sh603589,sh600873,sz000999,sz002067,sz002100,sz000338,sh600485,sz000656,sz000418,sh601158,sh601238,sz002050,sh600335,sz000498,sh601515,sh601678,sh600487,sh601058,sz000166,sz000811,sh600261,sz002304,sh601199,sh601928,sz000423,sh601985,sh601117,sh603806,sz000848,sz000415,sz002470,sh600644,sz002191,sh600035,sz000417,sh600743,sz002233,sh600196,sz002032,sh600327,sh601188,sh600422,sh601788,sz002588,sh600637,sz002557,sz000761,sz000650,sz002543,sh600761,sh601566,sh600021,sh600106,sh600499,sz002419,sh601618,sh600062,sh600284,sh600723,sz000869,sz000858,sz000404,sz000793,sz002124,sh600373,sz002372,sz002271,sh600522,sh601233,sh600617,sh600874,sz002344,sh600705,sz000825,sz002437,sh600649,sh600739,sh600168,sh600563,sh600368,sz000012,sh600388,sz000022,sz002002,sh600185,sz002466,sz002042,sz002071,sh600787,sh600664,sh600056,sh600820,sz000783,sh600983,sz000729,sz300026,sh600808,sz000802,sz300274,sz000565,sh600210,sh600583,sh600729,sz002705,sz002152,sz002367,sh600551,sh601877,sh600143,sh600611,sh600266,sh600183,sh601333,sz002317,sh603168,sh601555,sh600369,sh600863,sz300043,sh600057,sh600073,sz002454,sh603198,sz000546,sh601139,sz002087,sh600486,sh601128,sz002126,sz002074,sh601901,sz000700,sz000703,sh600518,sh600981,sz300267,sh600093,sz002203,sh601313,sz002594,sz300360,sh601677,sh601900,sz000690,sh600828,sh603001,sz002415,sh603366,sz000028,sz000789,sz002736,sz002004,sz002019,sh603609,sz000626,sz000750,sh600908,sh600252,sz002573,sh600396,sz000887,sz300182,sz002540,sh600138,sz002236,sz300017,sz002014,sh600658,sh600469,sz002065,sh600511,sz002595,sz300375,sz300070,sh601518,sh600337,sz300631,sz002508,sh600076,sz002293,sh600668,sh600510,sz300196,sh600597,sz002324,sh601018,sh600572,sz000627,sz002275,sz300627,sh600566,sh600681,sz002561,sz002033,sh600782,sh600239,sh600663,sh600750,sh600007,sh600726,sh600839,sh600557,sz000538,sh601222,sz002626,sh600856,sz000421,sz300284,sz002172,sz000728,sh600655,sh600477,sz002314,sh600197,sz002444,sz300129,sz002398,sz000666,sz000513,sh600519,sh603328,sz000096,sz000810,sz002501,sz000568,sz000665,sz000963,sz002056,sh600037,sz000993,sz002311,sh600838,sz002447,sh600885,sz300121,sz300253,sz002538,sz300033,sz000890,sz000591,sz002029,sh600827,sh600502,sz002108,sh600132,sh603323,sh603020,sh601965,sh600811,sh601001,sh601766,sz002270,sz300058,sh600530,sh600054,sz002299,sz002400,sh600380,sh600012,sz002385,sz000989,sh601966,sh600109,sz000910,sz000898,sz000402,sh603116,sh600126,sh600271,sz002187,sz001696,sh600051,sh601881,sz300146,sz002091,sh600325,sh600714,sh600973,sh600195,sz000430,sz000826,sz000709,sz300039,sh600966,sh601368,sz002238,sz300040,sh600995,sh600648,sz002062,sz300100,sz000813,sz300237,sz002502,sz300183,sz000301,sz002672,sz002396,sh601179,sz300108,sz002241,sz002517,sz000631,sz002533,sz002448,sh600332,sh600639,sh601588,sh601311,sz300144,sz002727,sh601231,sz002518,sh601888,sz002054,sh600643,sh600535,sh600676,sh601908,sz002857,sh603128,sh600529,sh600079,sh601718,sh600970,sh600159,sh600525,sh600329,sz002047,sh601216,sh600067,sz002507,sz002179,sh600635,sz300408,sz300204,sh600736,sh600703,sh600338,sz000919,sz002531,sh603306,sz002498,sz002323,sz002614,sh603288,sh600979,sh600201,sh600298,sz000928,sz000609,sh603899,sz000089,sz000559,sz300203,sh603599,sz000582,sz000951,sz002491,sz300443,sh603567,sh600218,sh600307,sz002433,sh603889,sh600131,sz002041,sz002028,sz002648,sz002468,sh601799,sz002641,sz002408,sh603368,sh600996,sz002548,sz002737,sh600985,sz002101,sz300269,sz002831,sz002482,sz002624,sz000596,sz002239,sz002247,sz002354,sz002310,sz000888,sz002220,sh601163,sz002020,sh601886,sz002382,sz002450,sh601038,sz002165,sz300258,sz300336,sh601567,sh600748,sz002158,sz300628,sh600993,sz300027,sz000830,sz000021,sz000521,sz000029,sh600850,sz300202,sh600119,sz002516,sz000034,sz000669,sh600986,sz000572,sz002407,sh600804,sh601801,sz002217,sz002185,sz300287,sh601198,sz300406,sz300339,sh600326,sh600517,sz300048,sz002746,sz000952,sz002133,sh600593,sz300195,sz002397,sz002195,sh603968,sz002615,sz300113,sz300171,sh600895,sz002391,sz002510,sz002567,sz002403,sz000915,sh600872,sz300145,sz002449,sz300002,sz002277,sz002008,sh600180,sh600211,sh600496,sz002182,sh601010,sh601689,sh600122,sz002258,sz002234,sz002035,sz000722,sh603868,sz002680,sz002653,sz000739,sz300197,sh603816,sz000090,sh603919,sz002206,sh600480,sz000997,sz002763,sh603656,sz002532,sh601789,sz300251,sz300497,sh600523,sz002521,sz000563,sh600594,sz000905,sz002085,sh603337,sz002039,sh600415,sz002666,sh603556,sz002060,sh600498,sz000005,sz002422,sh601899,sh603929,sh600229,sh603858,sz002392,sz002144,sh600997,sh600829,sz002581,sz300485,sh600188,sh601628,sh600657,sz002637,sz300207,sz002329,sh603228,sz000544,sz002769,sh603788,sz000860,sz002376,sh600969,sh600363,sh600246,sh600248,sz002183,sz002688,sz002452,sh600356,sh600406,sz300476,sh600479,sz300407,sz002790,sz002717,sh600626,sz000530,sz002550,sh600008,sz300130,sh600420,sz300124,sh600824,sh600074,sz002345,sh600783,sh601015,sh603639,sz002249,sh600116,sz002661,sh603035,sz300626,sz300037,sh600865,sz002080,sh603517,sz002410,sz002511,sz300323,sh603444,sh600958,sz002709,sz002138,sz002681,sz300115,sz300166,sz000156,sh600754,sz000733,sz000908,sz002555,sz002120,sz002745,sh601929,sz002038,sz002603,sz000661,sz300242,sz300133,sh603611,sz000796,sz300463,sh600661,sz002756,sh601700,sz002726,sz300265,sh601126,sz002025,sh603727,sh600172,sz002713,sh600017,sz002053,sz002534,sh603118,sz300389,sz000419,sh600382,sz002855,sz002636,sh600713,sz002690,sh600282,sz300303,sh603133,sh603355,sz002472,sh603026,sh600706,sh603099,sz300049,sh600845,sh603358,sz300170,sz002772,sz002326,sz300005,sz300255,sh603566,sh603886,sz002224,sh603989,sz300387,sz002643,sz002160,sz002496,sz002088,sz002479,sz000977,sz300098,sh600633,sz300271,sh600305,sz000049,sz002775,sh600843,sh601811,sh600105,sh600220,sh600595,sz002791,sz002174,sz002374,sz002536,sz002608,sz002343,sz002131,sh603585,sz300214,sz002283,sh603997,sz002150,sh603515,sh601218,sh600308,sh600114,sz002646,sz300446,sz300355,sh603900,sz300403,sz002559,sz002368,sh603979,sh600889,sz002221,sh601225,sz300079,sh601137,sz002026,sh600864,sz000088,sz002664,sh603686,sh601369,sz300071,sz002357,sh603883,sz300471,sz002223,sz000062,sh603528,sh600085,sz002106,sz002589,sh600810,sz002043,sz002007,sh600295,sz002320,sh600208,sh600708,sh603008,sz002677,sz002562,sh600809,sz300250,sz300297,sz002812,sz002411,sz002742,sh600458,sz000607,sz002404,sz002361,sz300470,sz002475,sh600452,sz002706,sz300395,sh601127,sz300440,sh600521,sh600101,sh600861,sz002519,sz002635,sz002245,sz300208,sh603100,sh600318,sh600006,sh603179,sh601777,sz002429,sh600867,sz002373,sz000018,sz002139,sz002556,sz000965,sz300003,sz002818,sh600814,sz002509,sz000889,sh603969,sz002462,sz002807,sz300291,sz300332,sz000903,sz000736,sz002022,sz002406,sz300295,sz300415,sz002181,sz000070,sz002171,sz300286,sz300041,sz000671,sz002541,sz000701,sz002630,sz002612,sz300357,sh600081,sh600780,sz002121,sz002262,sz300394,sz002527,sz000715,sz300396,sz002572,sz002749,sh600362,sz300072,sh600959,sz000961,sh603866,sz002137,sz002465,sh603798,sh603111,sh603708,sz300019,sz002579,sz300342,sz002792,sz300315,sz000413,sh600687,sz300326,sz002279,sh600439,sh603600,sz300119,sz300296,sz300373,sh603298,sz002013,sz300418,sh600582,sz002856,sh603568,sz300341,sz300172,sz002441,sz002111,sh600884,sh601099,sh600831,sh600869,sz300047,sz300335,sz300068,sh603038,sh600666,sh600629,sz002426,sh603018,sz300305,sz002123,sh600647,sh600977,sh600621,sh600276,sz000906,sz300256,sh600846,sh603165,sh600125,sh603818,sz300131,sz002833,sz002421,sh603313,sz002375,sz002718,sh603579,sh600830,sz300272,sh600317,sh601933,sh603199,sz300137,sz300010,sz300363,sz002673,sh601599,sz002768,sz300075,sh600575,sz300054,sh600734,sz300018,sh600053,sz002739,sh600765,sz002009,sz300194,sz000050,sz002318,sh600226,sz002250,sz002658,sz300388,sh603699,sh600086,sh600219,sz002366,sz300343,sz300050,sh600090,sh603006,sh603618,sz002218,sz300367,sh600683,sz002090,sz300358,sz300199,sz300439,sz002815,sh603518,sh600386,sz002328,sz300625,sz300262,sz002734,sz002098,sh603939,sz002208,sh600482,sz000536,sz300369,sh600879,sz002445,sh600971,sz000970,sh603208,sh600721,sh600917,sz002117,sz300138,sh600803,sz002360,sz300156,sz300178,sh603338,sh603569,sz002513,sz002748,sz300231,sz300193,sz000688,sh600233,sz000599,sh600650,sz300282,sz300056,sz002765,sz002186,sz000043,sz300088,sz002841,sh600988,sh600587,sh600310,sz300066,sh600602,sh600720,sh600179,sz300569,sz000035,sh603898,sz002300,sz002787,sz002237,sz300188,sz300020,sz002196,sz300221,sh600737,sz002464,sh603017,sz000823,sz002116,sz000967,sz002322,sz002832,sz300158,sz000507,sz000400,sz300127,sz002604,sz002302,sz300385,sz300484,sh603928,sz000756,sz002228,sz002018,sz300512,sz002788,sz300621,sz002732,sh600429,sz002424,sz002129,sz300350,sz300229,sh600491,sz002104,sz002616,sz300393,sh600399,sz002436,sz300519,sz300365,sz002118,sz002102,sh603393,sh603608,sh600475,sh601727,sz002650,sh603839,sz300148,sz300433,sz000949,sz002711,sh603037,sz300063,sh600622,sz300382,sz002036,sh603811,sz002668,sh600580,sz002497,sz300292,sh601999,sz002822,sz002143,sh600936,sz002049,sz000078,sh600763,sh603823,sh600515,sz300015,sh603258,sz300078,sz300055,sh600998,sz000882,sz002292,sz002619,sz002418,sz300438,sh603158,sh600436,sz300383,sh603996,sz000408,sz000920,sh600711,sz002456,sz002332,sz000552,sh600513,sz300224,sz002439,sh603345,sz002084,sz002503,sz002281,sh600699,sz002686,sz002068,sz300259,sz000723,sh600577,sz300319,sz000551,sz002099,sz002358,sz000151,sz300232,sz002219,sz300067,sz000545,sz300298,sh600278,sh603203,sz300580,sz002670,sh600567,sz002721,sz000529,sz002460,sh603012,sz002063,sz002600,sz300185,sh603160,sz000619,sz002094,sz300351,sz002523,sz002352,sh603089,sz002298,sz000712,sz300150,sh600589,sz300089,sz300495,sh603027,sz000673,sz000603,sz002631,sh600213,sz300009,sz300230,sz300320,sz002827,sz000861,sz002733,sh601595,sz002435,sh600178,sz002554,sh600738,sz000987,sz002649,sz002565,sz002412,sz300154,sz000026,sz000516,sz002156,sh603266,sz002252,sz002427,sh600113,sz000981,sz002350,sz002687,sh603309,sz002753,sh603669,sz300117,sh601996,sz300473,sz300432,sz002478,sz300025,sz002017,sh600223,sh603878,sz300218,sh600982,sh600292,sz300187,sz300477,sh600077,sz002585,sz002627,sh600654,sh603658,sz300602,sz002261,sh600182,sz000411,sz300252,sz002356,sz300317,sz002707,sh603959,sz300140,sz002079,sh600375,sz300370,sh603033,sh603098,sz000988,sh600063,sz300036,sh603360,sh600662,sz300013,sz300014,sh603877,sz002483,sz002609,sz300233,sz002840,sh603416,sz300450,sz002153,sz300136,sh603023,sh600797,sz002583,sz002273,sh600805,sz300163,sz002393,sh600419,sz300494,sz300622,sh600613,sz002654,sz300031,sz002484,sz002321,sz300200,sz002349,sh600779,sz002082,sh603421,sz002587,sh600965,sz002325,sh600289,sz002127,sz000790,sz002640,sz300116,sh600231,sz300240,sz300008,sz002773,sz002425,sz000716,sh600638,sz000978,sh603901,sz300596,sz002364,sz300511,sz300426,sz300210,sz300294,sz002821,sz002560,sz002776,sz000758,sh600568,sz300168,sz002463,sz300244,sz000548,sh600505,sz300448,sz000751,sz300568,sz300575,sh600569,sz300371,sz300324,sz002551,sz002276,sz300213,sz300547,sh603977,sh601375,sh603960,sh600909,sz002722,sh600851,sz300062,sz000778,sh601898,sh603186,sh603126,sz300577,sz000822,sz002750,sz002542,sz000983,sz002728,sh600038,sh600328,sh603218,sh601003,sz300488,sz300160,sz002315,sh603903,sh600136,sz002752,sz002845,sz300074,sz000514,sh600630,sz002553,sh603223,sz300457,sz300590,sz002642,sh603025,sz300587,sz002335,sz000061,sh603067,sz300007,sz002837,sz002712,sz300306,sz002592,sh603701,sz300362,sh603677,sz000153,sz002471,sz000570,sh600547,sz002399,sz000973,sh600059,sh603339,sh603808,sz002605,sz002793,sz002339,sh600345,sz300623,sz002500,sh603377,sz002296,sz300570,sh603987,sz300376,sz002783,sh603010,sz002601,sh600571,sh600796,sh600070,sz002390,sz300001,sz000639,sz300412,sz002370,sz002657,sz300429,sz002303,sh601611,sz002598,sz002487,sh600166,sh603626,sh600651,sz002823,sz300444,sz002770,sh600623,sh600279,sz000917,sh600189,sz300222,sz300219,sz000620,sh600552,sz002602,sz002757,sh603123,sz000850,sz002731,sz002580,sh603520,sh603955,sz002781,sz300307,sz002820,sh603060,sz000636,sz002446,sh603066,sz300595,sz300181,sz300310,sz300348,sz002308,sz300311,sz300246,sh601579,sh600336,sz002148,sz002416,sz300425,sh603688,sz002697,sz300501,sz002682,sz002590,sz002169,sz000009,sz300600,sz002333,sz300327,sh603630,sz300157,sh603101,sz002539,sz002652,sh603311,sz300190,sz002700,sz300302,sz300452,sz002546,sz300247,sz300316,sh603519,sz300475,sz002801,sz002716,sz002786,sh600163,sz300245,sh603778,sz002284,sh600277,sz002331,sz000979,sh600372,sz300500,sh600141,sz300502,sz300044,sz300094,sh600893,sh600128,sz002061,sz002835,sz000525,sz300559,sz002547,sz002537,sh600466,sh600976,sz300409,sz002852,sh603456,sz002006,sz002246,sz000975,sz000006,sz000576,sz300620,sz300533,sz002287,sz002130,sh603508,sh600984,sh600489,sz002607,sz300421,sz002197,sz300082,sz300509,sz300366,sz002434,sz300353,sz002675,sz300567,sh600503,sz000571,sz300527,sz002839,sz300241,sh603665,sh600481,sh603117,sz002620,sz002402,sh600715,sz002838,sz300325,sz300616,sh600801,sz300059,sh600351,sz002363,sz300384,sh603789,sh603637,sz002380,sh603726,sz002132,sz300416,sz300558,sz002280,sh600203,sz002365,sh600151,sh600500,sz300289,sz300270,sh600370,sz002593,sz002725,sz300507,sz002492,sz300435,sz300386,sz300004,sz002847,sz000807,sz002789,sz000838,sz002696,sz300499,sh603678,sh600751,sh600157,sz300561,sz002850,sz300248,sz002140,sz000735,sz300582,sz300573,sz002166,sh600833,sz002771,sz002114,sz002610,sh600604,sh603601,sz002190,sz300419,sh603555,sh603668,sz300104,sz000681,sh603667,sh603888,sz002057,sz000687,sh603738,sz002811,sz002692,sz002853,sh600330,sz002669,sz000799,sz000676,sz002255,sz300481,sz300209,sz002674,sh603077,sz000566,sz002176,sh603239,sz300349,sz000008,sh601880,sz300077,sh603689,sz300487,sz002103,sz300159,sz002743,sz300607,sz002016,sz002188,sz300583,sz002645,sz300430,sz300023,sz300468,sz002584,sh600459,sz002336,sh600798,sh603131,sz300528,sz300024,sz000886,sz000938,sh600367,sz300057,sh603069,sz300379,sz002824,sh600834,sz300381,sz000662,sh603615,sh600460,sz300032,sz002251,sh603638,sh600562,sz002037,sz300299,sh601717,sh603777,sz000032,sz300414,sz002766,sz300374,sz300610,sz300046,sz002455,sz002708,sz300572,sz000099,sh600854,sz300447,sh600161,sh600433,sz002170,sz300615,sz300516,sz300458,sz300455,sh600371,sz300321,sz300529,sz002828,sz300347,sh603330,sz300051,sz300543,sz000065,sh603869,sz002719,sh600280,sh601500,sh603021,sh603958,sh603032,sz300555,sz300400,sh601258,sh600559,sh600258,sh600533,sz300585,sh600857,sh600287,sh600785,sz300322,sz300212,sz002606,sz000930,sh603016,sz300536,sz002809,sz002724,sz000777,sh603838,sz300165,sz000038,sz000672,sz300021,sh603319,sz002173,sz300225,sz300464,sz000637,sz002678,sz300064,sz002740,sh600488,sz300314,sh603108,sz002825,sz002040,sh600616,sz002401,sz002381,sz300586,sz300011,sz300522,sz000652,sh603716,sz002086,sz300114,sh603887,sz300535,sz300548,sz300530,sz300109,sz300428,sz300012,sh601208,sh600260,sz002777,sz002340,sz300579,sh600381,sz300608,sh600078,sz002699,sz000868,sh601016,sz300285,sh601069,sz000534,sz300034,sz300599,sz002256,sh600315,sz300377,sz002222,sz300584,sz002647,sh603991,sh603011,sz300549,sz002334,sz002044,sz002830,sz002663,sz002301,sh600526,sh600118,sz002644,sh603238,sz300566,sz300565,sz000971,sh603558,sz300557,sh603999,sh603998,sz300334,sz300083,sh601007,sh600348,sz300427,sz000615,sz300092,sz300489,sh600570,sz300503,sz300546,sz300417,sz300053,sh603909,sz300482,sz002758,sz002097,sh603993,sh600550,sz300541,sh600379,sz300134,sz002259,sz000766,sz000792,sz000980,sz002136,sz300462,sh603336,sz002119,sz000502,sz002230,sz300278,sz002010,sz000851,sh600343,sz002405,sh600855,sz000901,sh600501,sh600677,sh600528,sz000877,sh600888,sh600449,sh600320';
