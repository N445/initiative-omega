<?php

namespace App\Service\Event;

use App\Entity\Event\RRule;

class RRuleEntityToArrayConf
{
    public static function getConf(RRule $RRule): array
    {
        $conf = [
            'FREQ'     => $RRule->getFREQUENCY(),
            'DTSTART'  => $RRule->getDTSTART()?->format(DATE_ATOM),
            'INTERVAL' => $RRule->getFREQUENCYINTERVAL() ?: 1,
            'WKST'     => $RRule->getWKST(),
            'COUNT'    => $RRule->getCOUNT(),
            'UNTIL'    => !$RRule->getCOUNT() ? $RRule->getUNTIL() : null,
        ];

        self::setSubData($conf, $RRule);

        return $conf;
    }

    private static function setSubData(array &$conf, RRule $RRule)
    {
        if ($RRule->getBYMONTH()) {
            $conf['BYMONTH'] = implode(',', $RRule->getBYMONTH());
//            return;
        }
        if ($RRule->getFREQUENCY() === 'YEARLY' && $RRule->getBYWEEKNO()) {
            $conf['BYWEEKNO'] = implode(',', $RRule->getBYWEEKNO());
//            return;
        }
        if (!in_array($RRule->getFREQUENCY(), ['DAILY', 'WEEKLY', 'MONTHLY']) && $RRule->getBYYEARDAY()) {
            $conf['BYYEARDAY'] = implode(',', $RRule->getBYYEARDAY());
//            return;
        }
        if ($RRule->getFREQUENCY() !== 'WEEKLY' && $RRule->getBYMONTHDAY()) {
            $conf['BYMONTHDAY'] = implode(',', $RRule->getBYMONTHDAY());
//            return;
        }
        if ($RRule->getBYDAY()) {
            $conf['BYDAY'] = implode(',', $RRule->getBYDAY());
//            return;
        }
        if ($RRule->getBYHOUR()) {
            $conf['BYHOUR'] = implode(',', $RRule->getBYHOUR());
//            return;
        }
        if ($RRule->getBYMINUTE()) {
            $conf['BYMINUTE'] = implode(',', $RRule->getBYMINUTE());
//            return;
        }
        if ($RRule->getBYSECOND()) {
            $conf['BYSECOND'] = implode(',', $RRule->getBYSECOND());
//            return;
        }
        if ($RRule->getBYSETPOS()) {
            $conf['BYSETPOS'] = implode(',', $RRule->getBYSETPOS());
//            return;
        }
    }
}
