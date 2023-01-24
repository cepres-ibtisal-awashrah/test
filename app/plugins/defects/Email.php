<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Email Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for email integration. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */
 
class Email_Defect_Plugin extends Defect_plugin
{
    const SLASH = '/';

    private $_to;
    private $_isAttachment = false;
    private static $_meta = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Email defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => false, // No lookup for this plugin
        'default_config' => 
        '; You can configure the email address of the
; recipient below. If you leave the recipient empty,
; the user can enter a custom email address in the
; defect dialog.
[email]
to=user@example.com
attachments=off'
    ];
    
    /**
     * Get Meta
     *
     * Expected to return meta data for this plugin such as Author,
     * Version, Description and supported plugin capabilities.
     * 
     * @return array
     */
    public function get_meta(): array
    {
        return self::$_meta;
    }

    /**
     * Validate Config
     *
     * Validates the plugin configuration that is entered in the site
     * or project settings.
     * 
     * @param string $config Configuration entered for the plugin.
     * 
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_config($config)
    {
        $ini = ini::parse($config);
        if (!isset($ini['email'])) {
            throw new ValidationException('Missing [email] group.');
        }
        $to = arr::get($ini['email'], 'to');
        if (!$to) {
            throw new ValidationException('Missing configuration for key to.');
        }
        if (!check::email($to) || $to === 'user@example.com') {
            $this->_recipientError();
        }
    }
    
    /**
     * Configure
     * 
     * Parse and store configuration in respective fields. 
     *
     * @param string $config Configuration for the plugin 
     *                       as specified in the site/project settings.
     *
     * @return void
     */
    public function configure($config)
    {
        $ini = ini::parse($config);
        $email = $ini['email'];
        $this->_to = $email['to'] ?? null;
        $this->_isAttachment = isset($email['attachments']) && $email['attachments'] === 'on';
    }
    
    /**
     * Prepare Push
     * 
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array $context Context information such as details
     *                       about the test case, the test and so on.
     * 
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = $this->_to 
            ? [] 
            : [
                'to' => [
                    'type' => 'string',
                    'label' => 'Email Address',
                    'required' => true,
                    'remember' => true
                ]
            ];
        $fields['subject'] = [
            'type' => 'string',
            'label' => 'Subject',
            'required' => true,
            'size' => 'full'
        ];
        $fields['description'] = [
            'type' => 'text',
            'label' => 'Body',
            'rows' => 10
        ];
        if ($this->_isAttachment) {
            $fields['attachments'] = [
                'type' => 'dropbox',
                'label'=>'Attachments',
                'required' => false,
                'size' => 'none'
            ];
        };

        return ['fields' => $fields];
    }
    
    /**
     * Get Subject Default
     * 
     * Builds and returns subject using context.
     *
     * @param array $context Context information such as test case details.
     * 
     * @return string
     */
    private function _getSubjectDefault($context): string
    {
        return '[TestRail] Failed test: '
            . current($context['tests'])->case->title
            . (
                $context['test_count'] > 1
                    ? ' (+others)'
                    : ''
            );
    }
    
    /**
     * Get Body Default
     * 
     * Builds and returns body using context.
     *
     * @param array $context Context information such as test case details.
     * 
     * @return string
     */
    private function _getBodyDefault($context): string
    {
        return $context['test_change']->description;
    }

    /**
     * Recipient Error
     * 
     * Throw the error for invalid recipient.
     *
     * @return void
     * 
     * @throws ValidationException
     */
    private function _recipientError()
    {
        throw new ValidationException(
            'Recipient is not a valid email address.'
        );
    }
    
    /**
     * Prepare Field
     * 
     * Call for each field of the push form to gather the field
     * data for the form.
     *
     * @param array  $context Context information such as details 
     *                        about the test case, the test and so on.
     * @param array  $input   Input data the user has entered in the
     *                        push dialog.
     * @param string $field   Field name 
     * 
     * @return array
     */
    public function prepare_field($context, $input, $field): array
    {
        $data = [];
        $prefs = arr::get($context, 'preferences');
        switch ($field) {
            case 'to':
                $data['default'] = arr::get($prefs, 'to');
                break;
            case 'subject':
                $data['default'] = $this->_getSubjectDefault($context);
                break;
            case 'description':
                $data['default'] = $this->_getBodyDefault($context);
                break;
        }
        
        return $data;
    }
    
    /**
     * Validate Push
     * 
     * Validates the entered input in push dialog.
     *
     * @param array $context Context information such as details 
     *                       about the test case, the test and so on.
     * @param array $input   Input data the user has entered in the
     *                       push dialog.
     * 
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_push($context, $input)
    { 
        if (isset($input['to']) && !check::email($input['to'])) {
            $this->_recipientError();
        }
    }

    /**
     * Push
     *
     * Executes the actual push request by sending the email.
     *
     * @param array $context     Context information such as details 
     *                           about the test case, the test and so on.
     * @param array $input       Input data the user has entered in the push dialog.
     * @param array $attachments Attachments list.
     * 
     * @return string 
     */ 
    public function push($context, $input, array $attachments = [])
    {
        $to = $input['to'] ?? $this->_to;   
        $renamed_attachments = [];
        foreach ($attachments ?? [] as $attachment) {
            $pathArray = explode(static::SLASH, $attachment);
            $fileName = array_pop($pathArray);
            $newFilePath = str_replace($fileName, $this->_getAttachedFileName($fileName), $attachment);
            files::copy($attachment, $newFilePath);
            $renamed_attachments[] = $newFilePath;
        }
        email::send($to, $input['subject'], $input['description'], $renamed_attachments);
        foreach ($renamed_attachments as $attachment) {
            unlink($attachment);
        }
    }

    /**
     * Get Attached Filename
     * 
     * Fetch pure filename from filepath.
     * 
     * @param string $filename User uploaded file path. 
     * 
     * @return string
     */
    private function _getAttachedFileName(string $filename): string
    {
        $str_position = strpos($filename, '.');
        if ($str_position !== false) {
            return substr(
                $filename, 
                ($str_position + 1), 
                strlen($filename)
            );
        }

        return $filename;
    }
}
