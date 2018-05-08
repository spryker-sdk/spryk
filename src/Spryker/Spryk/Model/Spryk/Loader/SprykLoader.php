<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Loader;

use Symfony\Component\Yaml\Yaml;

class SprykLoader implements SprykLoaderInterface
{
    /**
     * @param string $sprykName
     *
     * @return array
     */
    public function loadSpryk(string $sprykName): array
    {
        $pathToSpryks = implode(DIRECTORY_SEPARATOR, [
            APPLICATION_ROOT_DIR,
            'config',
            'spryk',
            'spryks',
        ]) . DIRECTORY_SEPARATOR;

        $pathToSpryk = sprintf('%s%s.yml', $pathToSpryks, $sprykName);

        return Yaml::parse(file_get_contents($pathToSpryk));
    }
}
