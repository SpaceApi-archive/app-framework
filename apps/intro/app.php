<?php

if(!defined("APPSDIR"))
    die("Direct access is not allowed!");


// inject your stylesheet if you need it
//$page->addStylesheet("$app_dir/css/style.css");

// inject your javascript if you need it
//$page->addScript("$app_dir/scripts/appname.js");

$html = <<<HTML

    <section>
        <h2>Space API Kickstart</h2>

        <h3>Add a new VirtualHost</h3>

        <p>If you use the apache web server, put the following VirtualHost to your apache configuration file.</p>

<pre><code>&lt;VirtualHost *:80>
    ServerAdmin root@localhost
    DocumentRoot "/srv/http/spaceapi_app"
    ServerName myapp.spaceapi.net
    &lt;Directory /srv/http/spaceapi_app>
                Options -Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
    &lt;/Directory>
&lt;/VirtualHost>
</code></pre>

        <p>In Arch Linux these are the files to be considered:
            <ul>
                <li><em>/etc/httpd/conf/httpd.conf</em></li>
                <li><em>/etc/httpd/conf/extra/httpd-vhosts.conf</em></li>
            </ul>
        </p>

        <h3>Configure your DNS</h3>

        Add a new entry to your <em>/etc/hosts</em>:

        <pre><code>127.0.0.1       myapp.spaceapi.net</code></pre>

        <h3>Prepare your repository</h3>

        <p>
            Create a new repository in your Github account or if Gitorious is your favourite git service provide, then in your Gitorious account.
        </p>
        <p>
            Here we assume that your username is johndoe and your app is about a map. Now run the following commands.
        </p>

        <pre><code>cd apps/myapp
git remote add myapp git@github.com:johndoe/map.git
git config branch.master.remote myapp
git config branch.master.merge refs/heads/master
git push
</code></pre>

        <h3>Develop your app</h3>

        Now use the content in <em>apps/myapp</em> as a starting point. Put your business logic, your javascript and stylesheets there. Don't forget to commit and push regularly.

        <pre><code>git commit &lt;your-canged-files>
git push</code></pre>


        <h3>Publish your app</h3>

        <h4>Github users</h4>

        If your work is done,

        <ol>
            <li>fork and clone the <a href="https://github.com/SpaceApi/apps" target="_blank">apps repository</a></li>
            <li>add your app as a submodule: <pre><code>git submodule add git://github.com/johndoe/map.git map</code></pre></li>
            <li>open menu.php and add a new entry for your app:

            <pre><code>$menu = array(
    "intro" => "Home",
    "map" => "The ultimate Space API map",
);</code></pre>
                The key <em>map</em> must be the same as your app directory name. The right part is the button text of the menu entry.
            </li>
            <li>
                Now commit your changes and send us a pull request. Then we'll have a look at your work and we'll finally accept it if there are no security concerns.</li>
        </ol>

    </section>
HTML;

$page->addContent($html);
