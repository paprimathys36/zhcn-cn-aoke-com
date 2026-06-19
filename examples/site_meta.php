<?php

/**
 * Site metadata container and description generator.
 *
 * This module holds meta information for a given site and provides
 * a utility to generate a short, human-readable description string.
 */

class SiteMeta
{
    private array $meta;

    /**
     * @param string $url    Site URL
     * @param string $name   Site name
     * @param string $tagline  Short tagline
     * @param array  $keywords  Primary keywords
     */
    public function __construct(
        string $url = 'https://zhcn-cn-aoke.com',
        string $name = 'Aoke',
        string $tagline = 'Your gateway to smart solutions',
        array $keywords = ['aoke', 'innovation', 'technology']
    ) {
        $this->meta = [
            'url'      => $url,
            'name'     => $name,
            'tagline'  => $tagline,
            'keywords' => $keywords,
        ];
    }

    /**
     * Set a single meta field.
     *
     * @param string $key   Field name (one of: url, name, tagline, keywords)
     * @param mixed  $value Field value
     * @return void
     */
    public function set(string $key, $value): void
    {
        if (array_key_exists($key, $this->meta)) {
            $this->meta[$key] = $value;
        }
    }

    /**
     * Get a single meta field.
     *
     * @param string $key Field name
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * Get all meta fields as an associative array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->meta;
    }

    /**
     * Generate a short description string from the meta data.
     *
     * The description is built by concatenating the name, tagline,
     * and a selection of keywords. All output is HTML-escaped.
     *
     * @param int $maxKeywords Maximum number of keywords to include (0 = all)
     * @return string
     */
    public function generateDescription(int $maxKeywords = 3): string
    {
        $name    = htmlspecialchars($this->meta['name'], ENT_QUOTES, 'UTF-8');
        $tagline = htmlspecialchars($this->meta['tagline'], ENT_QUOTES, 'UTF-8');

        $keywords = $this->meta['keywords'];
        if ($maxKeywords > 0) {
            $keywords = array_slice($keywords, 0, $maxKeywords);
        }
        $keywordsEscaped = array_map(function ($kw) {
            return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
        }, $keywords);

        $description = "{$name}: {$tagline}";
        if (!empty($keywordsEscaped)) {
            $description .= ' — ' . implode(', ', $keywordsEscaped);
        }

        return $description;
    }

    /**
     * Return the site URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->meta['url'];
    }
}

// -------------------------------------------------------------------------
// Example usage (uncomment to test)
// -------------------------------------------------------------------------

/*
$meta = new SiteMeta();
echo $meta->generateDescription() . "\n";
// Output: Aoke: Your gateway to smart solutions — aoke, innovation, technology

$meta->set('tagline', 'Empowering your digital journey');
echo $meta->generateDescription(2) . "\n";
// Output: Aoke: Empowering your digital journey — aoke, innovation
*/