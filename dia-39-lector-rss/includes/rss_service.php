<?php

declare(strict_types=1);

class RSSReader {
    private array $feeds = [
        'tech' => [
            'TechCrunch' => 'https://techcrunch.com/feed/',
            'Wired' => 'https://www.wired.com/feed/rss',
            'The Verge' => 'https://www.theverge.com/rss/index.xml'
        ],
        'mining' => [
            'Mining.com' => 'https://www.mining.com/feed/',
            'International Mining' => 'https://im-mining.com/feed/',
            'Mining Weekly' => 'https://www.miningweekly.com/rss/mining-weekly-all'
        ]
    ];

    /**
     * Fetches and parses RSS feeds for a given category.
     * 
     * @param string $category
     * @return array
     */
    public function getNews(string $category): array {
        if (!isset($this->feeds[$category])) {
            return [];
        }

        $all_items = [];
        foreach ($this->feeds[$category] as $source => $url) {
            $items = $this->fetchFeed($url, $source);
            $all_items = array_merge($all_items, $items);
        }

        // Sort by date (descending)
        usort($all_items, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return $all_items;
    }

    /**
     * Fetches a single RSS feed.
     */
    private function fetchFeed(string $url, string $source): array {
        $items = [];
        try {
            // Use a timeout to prevent hanging
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'user_agent' => 'PHP RSS Reader/1.0'
                ]
            ]);

            $content = @file_get_contents($url, false, $context);
            if ($content === false) {
                return [];
            }

            $xml = @simplexml_load_string($content);
            if ($xml === false) {
                return [];
            }

            // Handle both RSS 2.0 and Atom
            if (isset($xml->channel->item)) {
                // RSS 2.0
                foreach ($xml->channel->item as $entry) {
                    $items[] = [
                        'title' => (string)$entry->title,
                        'link' => (string)$entry->link,
                        'description' => $this->cleanDescription((string)$entry->description),
                        'pubDate' => (string)$entry->pubDate,
                        'timestamp' => strtotime((string)$entry->pubDate),
                        'source' => $source
                    ];
                }
            } elseif (isset($xml->entry)) {
                // Atom
                foreach ($xml->entry as $entry) {
                    $items[] = [
                        'title' => (string)$entry->title,
                        'link' => (string)$entry->link['href'],
                        'description' => $this->cleanDescription((string)$entry->summary ?: (string)$entry->content),
                        'pubDate' => (string)$entry->updated,
                        'timestamp' => strtotime((string)$entry->updated),
                        'source' => $source
                    ];
                }
            }

        } catch (Exception $e) {
            // Log error or ignore
        }

        return array_slice($items, 0, 10); // Limit to 10 items per source
    }

    /**
     * Cleans and truncates description.
     */
    private function cleanDescription(string $html): string {
        $text = strip_tags($html);
        $text = html_entity_decode($text);
        if (strlen($text) > 160) {
            $text = substr($text, 0, 157) . '...';
        }
        return $text;
    }
}
