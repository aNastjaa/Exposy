<?php
namespace Crmlva\Exposy;

class View 
{
    protected $data;

    public function __construct(string $layout, string $template, array $data = [])
    {
        $this->data = $data;

        // Set paths to header, footer, and template files
        $layout_header = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "{$layout}-header.php";
        $layout_footer = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "{$layout}-footer.php";
        $template_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR . "{$template}.php";
        $main_landing_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "main-landing.php";
        $header_landing_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "header-landing.php";

        // Include header based on conditions
        if ($template !== 'index' && $template !== 'login' && $template !== 'register') {
            $this->includeFile($layout_header);
        }

        // Include header-landing.php only for index.php
        if ($template === 'index') {
            $this->includeFile($header_landing_path);
            $this->includeFile($main_landing_path);
        }

        // Include the main template file
        $this->includeFile($template_path);

        // Include footer based on conditions
        if ($template !== 'login' && $template !== 'register') {
            $this->includeFile($layout_footer);
        }
    }

    protected function includeFile(string $file)
    {
        if (file_exists($file)) {
            extract($this->data); // Extract data for use in the included file
            include $file;
        } else {
            echo "File not found: {$file}\n";
        }
    }

    // Other methods like renderInputError(), title(), embedStylesheets(), embedScripts() remain as before
    public function renderInputError(string $name)
    {
        if (isset($this->data['errors']) && isset($this->data['errors'][$name])) {
            echo $this->data['errors'][$name];
        }
    }

    public function title(): string
    {
        return $this->data['title'] ?? 'Exposy';
    }

    public function embedStylesheets(array $hrefs): void
    {
        foreach ($hrefs as $href) {
            echo "<link rel=\"stylesheet\" href=\"{$href}\"/>\n";
        }
    }

    public function embedScripts(array $srcs): void
    {
        foreach ($srcs as $src) {
            echo "<script src=\"{$src}\" defer></script>\n";
        }
    }
}
