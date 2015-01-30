-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 30 Janvier 2015 à 02:24
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `DSM_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` varchar(255) NOT NULL,
  `information` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `deviceId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstDay` int(11) NOT NULL,
  `lastDay` int(11) NOT NULL,
  `deviceId` int(11) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(6) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`, `mail`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com'),
(2, 'user', 'user', 'user', 'user@user.com');
