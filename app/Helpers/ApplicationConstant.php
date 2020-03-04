<?php
namespace App\Helpers;

use Lang;
use App\Helpers\DropdownUtils;

class ApplicationConstant
{
    const YES_NO = [
        0 => 'no',
        1 => 'yes'
    ];
    
    const GENDER = [
        1 => 'male',
        2 => 'female'
    ];

    const ADMIN_TYPE = [
        'admin' => 'admin',
        'super_admin' => 'super_admin'
    ];
    
    const COUNTRY = [
        'jp' => 'japan',
    ];

    const PROVINCE =[
        'hokkaido' => 'hokkaido',
        'aomori' => 'aomori',
        'iwate' => 'iwate',
        'miyagi' => 'miyagi',
        'akita' => 'akita',
        'yamagata' => 'yamagata',
        'fukushima' => 'fukushima',
        'ibaraki' => 'ibaraki',
        'tochigi' => 'tochigi',
        'gunma' => 'gunma',
        'saitama' => 'saitama',
        'chiba' => 'chiba',
        'tokyo' => 'tokyo',
        'kanagawa' => 'kanagawa',
        'niigata' => 'niigata',
        'toyama' => 'toyama',
        'ishikawa' => 'ishikawa',
        'fukui' => 'fukui',
        'yamanashi' => 'yamanashi',
        'nagano' => 'nagano',
        'gifu' => 'gifu',
        'shizuoka' => 'shizuoka',
        'aichi' => 'aichi',
        'mie' => 'mie',
        'shiga' => 'shiga',
        'kyoto' => 'kyoto',
        'osaka' => 'osaka',
        'hyogo' => 'hyogo',
        'nara' => 'nara',
        'wakayama' => 'wakayama',
        'tottori' => 'tottori',
        'shimane' => 'shimane',
        'okayama' => 'okayama',
        'hiroshima' => 'hiroshima',
        'yamaguchi' => 'yamaguchi',
        'tokushima' => 'tokushima',
        'kagawa' => 'kagawa',
        'ehime' => 'ehime',
        'kochi' => 'kochi',
        'fukuoka' => 'fukuoka',
        'saga' => 'saga',
        'nagasaki' => 'nagasaki',
        'kumamoto' => 'kumamoto',
        'oita' => 'oita',
        'miyazaki' => 'miyazaki',
        'kagoshima' => 'kagoshima',
        'okinawa' => 'okinawa',
    ];

    const LANGUAGE = [
        'en' => 'en',
        'ja' => 'ja',
    ];

    const EVENT_TYPE = [
        //'fund-raise' => 'fund-raise',
        'volunteer' => 'volunteer',
        'social-activity' => 'social-activity',
    ];

    const ARTICLE_TYPE = [
        'opinion' => 'opinion',
        'idea' => 'idea',
        'report' => 'report',
        'event_progress' => 'event-progress',
    ];

    const COMMUNITY_TYPE = [
        'company' => 'company',
        'organization' => 'organization',
        'group' => 'group'
    ];

    const ANNOUNCEMENT_TYPE = [
        'update' => 'update'
    ];
    
    const CAREER_TYPE = [
        'permanent' => 'permanent',
        'freelance' => 'freelance',
    ];

    const CAREER_DIVISION = [
        'tech' => 'tech',
        'marketing' => 'marketing',
        'operation' => 'operation',
        'management' => 'management',
        'finance' => 'finance',
        'external-relation' => 'external-relation',
    ];

    const EVENT_SORT = [
        'newest' => 'newest',
        'almost-start' => 'almost-start',
        'almost-end' => 'almost-end',
        'most-supported' => 'most-supported',
        'most-discussion' => 'most-discussion',
    ];

    const MAIL_CATEGORY = [
        'account' => 'account'
    ];

    const MAIL_ACTION = [
        'email-registration-confirmation' => 'email-registration-confirmation'
    ];

    public static function getDropdown($constant)
    {
        $return = [];
        $items = constant('self::'.$constant);

        foreach($items as $key => $value) {
            $return[$key] = \Lang::get('application-constant.'.$constant.'.'.$value);
        }

        return $return;
    }

    public static function getLabel($constant, $key)
    {
        $items = constant('self::'.$constant);

        return \Lang::get('application-constant.'.$constant.'.'.$items[$key]);
    }
}
