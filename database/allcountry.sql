-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2020 at 04:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emart`
--

-- --------------------------------------------------------

--
-- Table structure for table `allcountry`
--

CREATE TABLE `allcountry` (
  `id` int(11) NOT NULL,
  `iso` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allcountry`
--

INSERT INTO `allcountry` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'TP', 'EAST TIMOR', 'East Timor', 'TMP', NULL, 626),
(63, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(64, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(65, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(66, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(67, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(68, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(69, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(70, 'XA', 'EXTERNAL TERRITORIES OF AUSTRALIA', 'External Territories of Australia', 'CXR', 162, 61),
(71, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(72, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(73, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(74, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(75, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(76, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(77, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(78, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(79, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(80, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(81, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(82, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(83, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(84, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(85, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(86, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(87, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(88, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(89, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(90, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(91, 'GG', 'GUERNSEY AND ALDERNEY', 'Guernsey and Alderney', 'GGY', 1481, 44),
(92, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(93, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(94, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(95, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(96, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(97, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(98, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(99, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(100, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(101, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(102, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(103, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(104, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(105, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(106, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(107, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(108, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(109, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(110, 'JE', 'JERSEY', 'Jersey', 'JEY', 1534, 44),
(111, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(112, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(113, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(114, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(115, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(116, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(117, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(118, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(119, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(120, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(121, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(122, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(123, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(124, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(125, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(126, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(127, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(128, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(129, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(130, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(131, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(132, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(133, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(134, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(135, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(136, 'IM', 'ISLE OF MAN (Isle of)', 'Isle of Man', 'IMN', NULL, 1624),
(137, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(138, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(139, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(140, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(141, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(142, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(143, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(144, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(145, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(146, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(147, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(148, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(149, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(150, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(151, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(152, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(153, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(154, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(155, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(156, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(157, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(158, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(159, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(160, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(161, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(162, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(163, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(164, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(165, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(166, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(167, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(168, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(169, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(170, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(171, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(172, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(173, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(174, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(175, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(176, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(177, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(178, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(179, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(180, 'RO', 'ROMANIA', 'Romania', 'ROU', 642, 40),
(181, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 7),
(182, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(183, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(184, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(185, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(186, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(187, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(188, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(189, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(190, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(191, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(192, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(193, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(194, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(195, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(196, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(197, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(198, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(199, 'XG', 'SMALLER TERRITORIES OF THE UK', 'Smaller Territories of the UK', 'XXG', NULL, 44),
(200, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(201, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(202, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(203, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(204, 'SS', 'SOUTH SUDAN', 'South Sudan', 'SSD', 728, 211),
(205, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(206, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(207, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(208, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(209, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(210, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(211, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(212, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(213, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(214, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(215, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(216, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(217, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(218, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(219, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(220, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(221, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(222, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(223, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(224, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(225, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(226, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(227, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(228, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(229, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(230, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(231, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(232, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(233, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(234, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(235, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(236, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(237, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(238, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(239, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(240, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(241, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(242, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(243, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(244, 'YU', 'YUGOSLAVIA', 'Yugoslavia', 'YUG', 891, 38),
(245, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(246, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263),
(247, 'TL', 'TIMOR-LESTE', 'Timor-Leste', 'TLC', NULL, 670);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allcountry`
--
ALTER TABLE `allcountry`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allcountry`
--
ALTER TABLE `allcountry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
