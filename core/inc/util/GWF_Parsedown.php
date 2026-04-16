<?php

require_once __DIR__ . '/../3p/ParsedownCheckbox.php';


final class GWF_Parsedown extends ParsedownCheckbox
{
    protected function blockFencedCodeComplete($Block)
    {
        if (!GWF_GESHI_PATH) {
            return $Block;
        }
        require_once GWF_GESHI_PATH;

        $source = $Block['element']['element']['text'] ?? '';

        $language = '';
        if (isset($Block['element']['element']['attributes']['class'])) {
            $language = Common::substrFrom($Block['element']['element']['attributes']['class'], 'language-');
        }

        $geshi = new GeSHi($source, $language ? $language : 'Plaintext');

        $type = GESHI_HEADER_PRE;  // GESHI_HEADER_PRE_TABLE;
        $geshi->set_header_type($type);

        $copy = sprintf('<button class="gwf_copy_code_btn" onclick="return bbCopyCode(this)" data-copied="%s">%s</button>', GWF_HTML::lang('copied'), GWF_HTML::lang('copy_code'));

        $html = '<div class="gwf_bb_code">' . $copy . $geshi->parse_code() . '</div>';

        return [
            'type' => 'element',
            'element' => [
                'rawHtml' => $html,
                'allowRawHtmlInSafeMode' => true,
            ],
        ];
    }
}
