-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 May 2015, 23:50:45
-- Sunucu sürümü: 5.6.17
-- PHP Sürümü: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `kralfaruk`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) NOT NULL,
  `content` text,
  `img` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `page` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `content`
--

INSERT INTO `content` (`id`, `header`, `content`, `img`, `active`, `page`) VALUES
(1, '2015 Yılı Yaz Sezonu', ' Kral Faruk Kır Düğün Salonunda 2015 yılı Yaz Sezonu Rezervasyonlarımız başlamıştır.\r\n            Detaylı Bilgi İçin  <a href="#/nav/content"> Tıklayınız</a>', 'assets/img/home/bridenmaid.jpg', 1, 1),
(2, 'Mutluluğunuzu Ölümsüzleştirelim', 'Kral Faruk Kır Düğün Salonu,   Kır Düğünü anlayışına yepyeni bir soluk, yepyeni bir yüz.\r\n            Özel günlerinizi, özel   yaşamanız için sizin yerinize  tüm detayları düşünerek unutulmaz\r\n            organizasyonlara ev sahipliği yapıyor. 1000 kişilik Kır Bahçemiz  ,\r\n            kır düğünlerinizi birer şölene dönüştürüyor. Özel günleriniz keyif verici aktiviteler olarak anılacak ve hafızalardan bir ömür boyu silinmeyecek. \r\n            Bırakın organizasyonun tüm detayları ile Kral Faruk Kır Düğün Salonu''nun deneyimli/uzman kadrosu ilgilensin,\r\n            siz yalnız bu özel günün keyfini yaşayın...', 'assets/img/home/bridenmaid3.jpg', 1, 1),
(3, 'header', 'content', 'assets/img/home/img.png', 1, 1),
(4, 'heaİŞÇÖÜĞder', 'content', 'assets/img/home/img.png', 1, 1),
(5, 'İŞÇÖÜĞüğişçö', 'işçöüğÜĞİŞÇÖ', 'ass', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `messagetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name_message_fti` (`name`,`message`) COMMENT 'name_message_fti'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `tel`, `message`, `messagetime`) VALUES
(1, 'deded', 'de@de.com', '2340934', 'mesajÄ±m', '2015-05-22 22:39:13'),
(2, 'deniz', 'deniz@deniz.com', '930485093845', 'mesajim', '2015-05-22 22:45:24'),
(3, 'deniz demirci', 'denizdemirci@ymail.com', '3403403403', 'Mesajim yeni mesaj hacÄ±lar', '2015-05-22 23:39:14'),
(4, 'deniz demirci', 'denizdemirci@ymail.com', '5055070686', 'mesaj hazÄ±rlanÄ±yor uzunca bir mesaj yazÄ±lacak simdi bakalim nasil gorunecek', '2015-05-23 11:11:41'),
(5, 'deniz demirci', 'denizdemirci@ymail.com', '5055070686', 'Ä°kinci bebeÄŸime 35 haftalÄ±k hamileydim. 35 haftanÄ±n 35â€™ini de â€˜acaba ikinci Ã§ocuÄŸumu da birincisi kadar sevebilecek miyim, ya sevmezsem, ya daha fazla seversem, ya -en kÃ¶tÃ¼sÃ¼- bebek yÃ¼zÃ¼nden ilk Ã§ocuÄŸumu ihmal edersem???â€™ diyerek geÃ§irmiÅŸtim. Bu korkularÄ±mÄ±n yersiz olduÄŸunu sonradan gÃ¶recektim, ancak o zamanlarda benim iÃ§in tek gerÃ§ek vardÄ±: Ä°kinci bir bebeÄŸim olacak diye birinci bebeÄŸimi ihmal etmemem gerektiÄŸiâ€¦ O kadar ki, 35â€™inci haftanÄ±n Ã¼Ã§Ã¼ncÃ¼ gÃ¼nÃ¼nde sabah beklenmedik bir ÅŸekilde kasÄ±lmalarla uyanÄ±p, doktor randevusundan â€˜5 santim aÃ§Ä±lmanÄ±z var, eve gidip, Ã§antanÄ±zÄ± alÄ±p, hastaneye yatÄ±ÅŸ yapÄ±yorsunuzâ€™ diye Ã§Ä±ktÄ±ÄŸÄ±mda bile ilk adresim ev deÄŸil, oyuncak dÃ¼kkanÄ± olmuÅŸtu. Derin yola Ã§Ä±kmÄ±ÅŸtÄ±, Deniz abi olacaktÄ±, kardeÅŸi geliyordu, eh, â€˜eli boÅŸâ€™ gelecek deÄŸildi ya, abisine bir hediye getirmesi gerekiyordu elbetâ€¦ Ya Deniz hastaneye geldiÄŸinde ben ona â€˜abi olma hediyesiâ€™ni hazÄ±r etmemiÅŸ olsaydÄ±m, ya kardeÅŸinden gÄ±cÄ±k kapsaydÄ±, ya onu ihmal ettiÄŸimizi dÃ¼ÅŸÃ¼nseydi, kim verecekti bunun hesabÄ±n ha kim?!?!? [Derin nefesâ€¦] Neyse sonuÃ§ olarak ben o gÃ¼n doÄŸuma gitmeden Derinâ€™in Denizâ€™e getirdiÄŸi lego duplo treni aldÄ±m, hastane Ã§antama koydum, doÄŸumumu yaptÄ±m ve Deniz kardeÅŸini gÃ¶rmeye geldiÄŸinde de ona â€˜abi olduÄŸu iÃ§inâ€™ hediyesini verdik. Ä°ÅŸlem tamamdÄ±. Harika bir anneydim benâ€¦ HiÃ§ ihmal etmemiÅŸtim bÃ¼yÃ¼k Ã§ocuÄŸumuâ€¦ Aferindi banaâ€¦ DoÄŸumu takip eden aylarÄ± da Denizâ€™i ihmal etmemek Ã¼zere kurguladÄ±k ve Ã¶yle de geÃ§irdik. ÃœÃ§ buÃ§uk senedir ailesinin ilgi odaÄŸÄ± haline gelmiÅŸ bir yavrucaÄŸÄ± sÄ±rf kardeÅŸi oldu diye bir kenara atmak doÄŸru olmazdÄ± tabiiâ€¦ Derin uyurken ben zaten Denizâ€™leydim, yardÄ±mcÄ±mÄ±z da vardÄ± artÄ±k, ondan destek alÄ±yorduk Ã§oÄŸu zaman. Her ne kadar ben sÃ¼per-kahraman-anne olarak her ÅŸeyin altÄ±ndan kalkmaya Ã§alÄ±ÅŸsam ve iki Ã§ocuÄŸuma tastamam yetmeye Ã§alÄ±ÅŸsam da bu o kadar kolay olmuyordu. Ã‡oÄŸu zaman kendimi bÃ¶lÃ¼k pÃ¶rÃ§Ã¼k hissediyordum.', '2015-05-23 11:13:04'),
(6, 'ali', 'ali@veli.com', '5055055050', 'MEsajÄ±m deli mesajÄ±m geliyor yollarda Ã§ay iÃ§iyom balkonda', '2015-05-25 20:07:44');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=188 ;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `phone`, `password`, `address`, `city`, `created`) VALUES
(187, 'adminadmin', 'kralfarukdugunsalonu@gmail.com', '5053953671', 'Ankara12345', 'Kula', 'Manisa', '2015-05-25 01:40:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
