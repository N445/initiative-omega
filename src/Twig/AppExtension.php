<?php

namespace App\Twig;

use App\Entity\Exploit\Exploit;
use App\Entity\Exploit\Tag;
use App\Entity\Rsi\Ship\Manufacturer;
use App\Entity\Rsi\Ship\Ship;
use App\Service\Seo\RichSnippetProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private RichSnippetProvider       $richSnippetProvider;

    private KernelInterface           $kernel;

    private EntrypointLookupInterface $entrypointLookup;

    private Environment               $twig;

    public function __construct(
        EntrypointLookupInterface $entrypointLookup,
        RichSnippetProvider       $richSnippetProvider,
        KernelInterface           $kernel,
        Environment               $twig
    )
    {
        $this->richSnippetProvider = $richSnippetProvider;
        $this->kernel              = $kernel;
        $this->entrypointLookup    = $entrypointLookup;
        $this->twig                = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getRichSnippet', [$this->richSnippetProvider, 'getRichSnippetGlobal']),
            new TwigFunction('getExploitFiltersClasses', [$this, 'getExploitFiltersClasses']),
            new TwigFunction('encore_entry_css_source', [$this, 'getEncoreEntryCssSource']),
            new TwigFunction('render_main_btn', [$this, 'render_main_btn'], ['is_safe' => ['html']]),
        ];
    }

    public function getExploitFiltersClasses(Exploit $exploit): string
    {
        $shipsClasses         = array_map(fn(Ship $ship) => sprintf("ship-%d", $ship->getId()), $exploit->getShips()->toArray());
        $manufacturersClasses = array_map(fn(Manufacturer $manufacturer) => sprintf("manufacturer-%d", $manufacturer->getId()), $exploit->getManufacturers()->toArray());
        $tagsClasses          = array_map(fn(Tag $tag) => sprintf("tag-%d", $tag->getId()), $exploit->getTags()->toArray());
        $classes              = array_merge($shipsClasses, $manufacturersClasses, $tagsClasses);
        return implode(' ', $classes);
    }

    public function getEncoreEntryCssSource(string $entryName): string
    {
        $files  = $this->entrypointLookup->getCssFiles($entryName);
        $source = '';
        foreach ($files as $file) {
            $source .= file_get_contents($this->kernel->getProjectDir() . '/public' . '/' . $file);
        }
        return $source;
    }

    public function render_main_btn(
        string  $text,
        ?string $link = null,
        ?array  $options = [],
    ): string
    {
        return $this->twig->render('render/main-btn-render.html.twig', [
            'text'       => $text,
            'link'       => $link,
            'isSubmit'   => $options['isSubmit'] ?? false,
            'type'       => $options['type'] ?? 'primary',
            'linkAttr'   => $options['linkAttr'] ?? null,
            'classes'    => $options['classes'] ?? null,
            'beforeHtml' => $options['beforeHtml'] ?? null,
            'afterHtml'  => $options['afterHtml'] ?? null,
        ]);
    }
}
