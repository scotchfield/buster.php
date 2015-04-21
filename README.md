# buster.php
Buster recommends neat stuff for you to post to your Twitter feed. It's the PHP implementation of [Buster](https://github.com/scotchfield/buster).

Check it out here: [http://buster.click](http://buster.click)

## High-Level Description
Buster is a combination of React, PHP, and MySQL. Buster scours the net for popular links and stores them for you. If you need something fun to post to your Twitter feed, Buster can recommend something.

## What's it doing?
On the backend, Buster is periodically polling Reddit's hot links and storing anything that it hasn't seen before as a new row in a MySQL database.

On the frontend, Buster is using React to poll the backend to serve a new random link from the database.

If you want to post to your Twitter feed, the cached link is passed to the Twitter Intent URL. There's no logging in, no extra work. If you don't like a link, just click the red X, and it's gonzo.

For more links, click the "One more?" button, and another one will show up.
