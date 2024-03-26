<?php
/**********************************************************************************
 * @Project    KYG Framework for business
 * @Version    1.0,0
 *
 * @Copyright  (C) 2025 Kataev Yaroslav Georgievich 
 * @E-mail     yaroslaw74@gmail.com
 * @License    GNU General Public License version 3 or later; see LICENSE.md
 *********************************************************************************/
namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\EnvVarLoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

final class YamlEnvVarLoader implements EnvVarLoaderInterface
{
    private const ENV_VARS_FILE = 'env.yaml';

    public function loadEnvVars(): array
    {
        $fileName = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . self::ENV_VARS_FILE;
        $filesystem = new Filesystem();
        if (!$filesystem->exists($fileName)) {
            return [];
        } else {
            $content = Yaml::parseFile($fileName);
            return $content['vars'];
        }
    }
}