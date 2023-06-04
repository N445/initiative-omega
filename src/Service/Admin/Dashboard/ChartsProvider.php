<?php

namespace App\Service\Admin\Dashboard;

use App\Entity\Rsi\Ship\Ship;
use App\Repository\Member\MemberRepository;
use App\Repository\Rsi\Ship\ShipRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartsProvider
{
    private ChartBuilderInterface $chartBuilder;

    private MemberRepository      $memberRepository;

    private ShipRepository        $shipRepository;

    public function __construct(
        ChartBuilderInterface $chartBuilder,
        MemberRepository      $memberRepository,
        ShipRepository        $shipRepository
    )
    {
        $this->chartBuilder     = $chartBuilder;
        $this->memberRepository = $memberRepository;
        $this->shipRepository   = $shipRepository;
    }

    /**
     * @return Chart|null
     */
    public function getMemberChart(): ?Chart
    {
        $members = $this->memberRepository->getDashboardUsers();

        if (!$member = $members[0] ?? null) {
            return null;
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $labels   = [];
        $datasets = [];
        foreach ($member->getXpData() as $xpDatum) {
            $labels[] = $xpDatum->getDate()->format('d/m/Y H:i');
        }

        $colors = ['#66c2a5', '#fc8d62', '#8da0cb', '#e78ac3', '#a6d854', '#ffd92f', '#e5c494', '#b3b3b3', '#e41a1c', '#377eb8', '#4daf4a', '#984ea3', '#ff7f00', '#ffff33', '#a65628', '#f781bf', '#999999'];

        foreach ($members as $key => $member) {
            $data = [];
//            $color = $colors[array_rand($colors)];
            $color = $colors[$key];
            foreach ($member->getXpData() as $xpDatum) {
                $data[] = $xpDatum->getValue();
            }
            $datasets[] = [
                'label'           => $member->getName(),
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'data'            => $data,
            ];
        }

        $chart->setData([
            'labels'   => $labels,
            'datasets' => $datasets,
        ]);

        return $chart;
    }

    public function getShipsChart()
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $ships = $this->shipRepository->getShipsWithFleetsSorted();

        $labels = $this->getShipsLabel($ships);
        $bools  = [true, false];

        $datasets = [];
        foreach ($bools as $bool) {
            $data    = [];
            $dataset = [
                'label'           => $bool ? 'Nombre de ship dans la corpo achat in game' : 'Nombre de ship dans la corpo achat IRL',
                'backgroundColor' => $bool ? '#66c2a5' : '#fc8d62',
                'borderColor'     => $bool ? '#66c2a5' : '#fc8d62',
            ];

            foreach ($ships as $ship) {
                $data[] = $ship->getNbTotalInFleets($bool);
            }
            $dataset['data'] = $data;
            $datasets[]      = $dataset;
        }

        $chart->setData([
            'labels'   => $labels,
            'datasets' => $datasets,
        ]);

        return $chart;
    }

    private function getShipsLabel(array $ships)
    {
        $labels = [];
        uasort($ships,
            function (Ship $shipA, Ship $shipB) {
                return $shipA->getNbTotalInFleets() > $shipB->getNbTotalInFleets() ? -1 : 1;
            });

        foreach ($ships as $ship) {
            if (!$ship->getNbTotalInFleets()) {
                continue;
            }
            $labels[] = $ship->getName();
        }
        return $labels;
    }
}
