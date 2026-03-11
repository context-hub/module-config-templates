<?php

declare(strict_types=1);

namespace Butschster\ContextGenerator\Template\Detection\Strategy;

use Butschster\ContextGenerator\Application\FSPath;
use Butschster\ContextGenerator\Template\Detection\TemplateDetectionResult;
use Butschster\ContextGenerator\Template\Registry\TemplateRegistry;

/**
 * Fallback detection strategy that returns the generic template when no other strategy matches
 */
final readonly class FallbackDetectionStrategy implements TemplateDetectionStrategy
{
    private const float CONFIDENCE_THRESHOLD = 0.0;
    private const string FALLBACK_TEMPLATE_NAME = 'generic';

    public function __construct(
        private TemplateRegistry $templateRegistry,
    ) {}

    public function detect(FSPath $projectRoot, array $projectMetadata): ?TemplateDetectionResult
    {
        $template = $this->templateRegistry->getTemplate(self::FALLBACK_TEMPLATE_NAME);

        if ($template === null) {
            return null;
        }

        return new TemplateDetectionResult(
            template: $template,
            confidence: 0.0,
            detectionMethod: 'fallback',
            metadata: [
                'projectMetadata' => $projectMetadata,
                'reason' => 'Fallback detection - no specific project type detected',
            ],
        );
    }

    public function getConfidenceThreshold(): float
    {
        return self::CONFIDENCE_THRESHOLD;
    }

    public function getPriority(): int
    {
        return 1;
    }

    public function getName(): string
    {
        return 'fallback';
    }
}
