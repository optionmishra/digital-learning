<?php

namespace App\Services\Migration\Transformers;

class TransformerFactory
{
    private $transformers = [];

    public function __construct()
    {
        // Register all transformers
        $this->registerTransformers();
    }

    public function getTransformer(string $sourceTable, string $targetTable): TransformerInterface
    {
        $key = "{$sourceTable}_{$targetTable}";

        // Check for specific transformer
        if (isset($this->transformers[$key])) {
            return $this->transformers[$key];
        }

        // Return default transformer if no specific one found
        return $this->transformers['default'];
    }

    private function registerTransformers(): void
    {
        // Register default transformer
        $this->transformers['default'] = new DefaultTransformer;

        // Register specific transformers
        $this->transformers['web_user_users'] = new UserTransformer;
        $this->transformers['web_user_user_role'] = new UserRoleTransformer;
        $this->transformers['web_user_user_profiles'] = new UserProfileTransformer;
        $this->transformers['category_content_types'] = new ContentTypeTransformer;
        $this->transformers['subject_books'] = new BookTransformer;
    }
}
