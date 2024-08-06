<?php

namespace Crmlva\Exposy;

class View 
{
    protected $data;

    public function __construct(string $layout, string $template, array $data = [])
    {
        $this->data = $data;

        $header_landing_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "header-landing.php";
        $main_footer_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "main-footer.php";
        $main_header_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "main-header.php";
        $main_landing_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "main-landing.php";
        $auth_template_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR . "{$template}.php";
        $error_template_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . "{$template}.php";
        $error_header_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "error-header.php";
        $error_footer_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "error-footer.php";
        $user_profile_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "user-profile.php";
        $events_suggestion_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "event-suggestion.php";
        $events_explorer_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "events-explorer-grid.php";
        $saved_user_events_path = TEMPLATES_DIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . "saved-user-events.php";

        switch ($template) {
            case 'index':
                $this->includeIfExists($header_landing_path);
                $this->includeIfExists($main_landing_path);
                $this->includeIfExists($main_footer_path);
                break;

            case 'events':
                $this->includeIfExists($main_header_path);
                $this->includeIfExists($events_suggestion_path);
                $this->includeIfExists($events_explorer_path);
                $this->includeIfExists($main_footer_path);
                break;

            case 'account': 
                $this->includeIfExists($main_header_path);
                $this->includeIfExists($user_profile_path);
                $this ->includeIfExists($saved_user_events_path);
                $this->includeIfExists($main_footer_path);
                break;   

            case 'login':
            case 'register':
                $this->includeIfExists($auth_template_path);
                break;

            case '403':
            case '404':
                $this->includeIfExists($error_header_path);
                $this->includeIfExists($error_template_path);
                $this->includeIfExists($error_footer_path);
                break;

            default:
                $this->includeIfExists($main_header_path);
                $this->includeIfExists($main_footer_path);
                break;
        }
    }

    private function includeIfExists(string $path): void
    {
        if (file_exists($path)) {
            include_once $path;
        } else {
            echo "File not found: {$path}\n";
        }
    }

    public function renderInputError(string $name): void
    {
        if (isset($this->data['errors']) && isset($this->data['errors'][$name])) {
            $errors = $this->data['errors'][$name];

            if (!is_array($errors)) {
                $errors = [$errors];
            }

            echo '<ul class="error-list">';
            foreach ($errors as $error) {
                echo "<li class=\"error\">{$error}</li>";
            }
            echo '</ul>';
        }
    }

    public function getInputValue(string $name): string
    {
        return htmlspecialchars($this->data['submitted_data'][$name] ?? '', ENT_QUOTES);
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
