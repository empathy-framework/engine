<?php

namespace Empathy\Engine\Components;

class FolderBrowserDialog extends CommonDialog
{
    protected ?string $classname = 'System.Windows.Forms.FolderBrowserDialog';
	
    public function get_path ()
    {
        return $this->getProperty ('SelectedPath');
    }
}
