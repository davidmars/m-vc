<?php
/**
 * User: francois
 * Date: 01/11/12
 * Time: 09:06
 * This class define static variables that make relationship beetween the database and the project structure.
 * This is in config because your database can change from a server to an other one.
 */
class StaticDatas
{
    /**
     * @var string the embedFooter url from Havana Club
     */
    public static $embedFooter = 'http://havanaclub.shic.cc/embedFooter';

    /**
     * @var string the embedHeaderMenu url from Havana Club
     */
    public static $embedHeaderMenu = 'http://havanaclub.shic.cc/embedMenu';

    /**
     * @var string the embedHeaderSubMenu url from Havana Club
     */
    public static $embedHeaderSubMenu = 'http://havanaclub.shic.cc/embedSubMenu';
}
