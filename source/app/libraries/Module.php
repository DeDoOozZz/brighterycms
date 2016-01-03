<?php


class Module
{

    public function isInstalled($module = null)
    {

    }

    public function saveSettings($module, $data)
    {
        $_module = Brightery::SuperInstance()->Database->where('raw_name', $module)->get('modules')->row();
        if (!$_module)
            Brightery::SuperInstance()->Database->insert('modules', [
                'raw_name' => $module,
                'name' => $module,
                'status' => 1,
                'settings' => json_encode($data)
            ]);
        else
            Brightery::SuperInstance()->Database->where('raw_name', $module)
                ->update('modules', [
                    'settings' => json_encode($data)
                ]);
    }

    public function getSettings($module)
    {
        $module = Brightery::SuperInstance()->Database->where('raw_name', $module)->get('modules')->row();
        if (isset($module->settings))
            return json_decode($module->settings);
    }
}