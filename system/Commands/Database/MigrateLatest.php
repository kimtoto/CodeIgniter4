<?php namespace CodeIgniter\Commands\Database;

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	CodeIgniter Dev Team
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

/**
 * Creates a new migration file.
 *
 * @package CodeIgniter\Commands
 */
class MigrateLatest extends BaseCommand
{
    protected $group = 'Database';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'migrate:latest';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Migrates the database to the latest schema.';

    /**
     * Ensures that all migrations have been run.
     */
    public function run(array $params=[])
    {
        $runner = Services::migrations();

        CLI::write(lang('Migrations.migToLatest'), 'yellow');

        $namespace = CLI::getOption('n');
        $group =    CLI::getOption('g'); 
        
        try {
            if (! is_null(CLI::getOption('all'))){        
                $runner->latestAll($group);
            }else{                 
                $runner->latest($namespace,$group);
            }
            $messages = $runner->getCliMessages();
            foreach ($messages as $message) {
                CLI::write($message); 
            }
            
        }
        catch (\Exception $e)
        {
            $this->showError($e);
        }

        CLI::write('Done');
    }
}
