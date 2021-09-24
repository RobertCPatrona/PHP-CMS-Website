# PHP CMS Website

### Installation on localhost
1. Install XAMPP and launch it. Once XAMPP is up and running, start the Apache Server and MySQL Server.
2. Copy and paste the `cms` folder into your XAMPP installation folder, inside the `htdocs` folder, you should have `yourinstallpath/xampp/htdocs/cms`.
3. Import the Database. Go to `phpMyAdmin` on https://localhost/phpmyadmin/. There you need to create a new database called `cms` and then import the database file `cms.sql`. You should now have a `cms` databse with some data in it, imported from the `cms.sql` file. Once the database is imported, you can start using the website. 
4. Go to https://localhost/cms/ to access and use the website. Please continue reading to learn about the website's structure and login data. 

### About the CMS Website
A website for posting posts, commenting, liking, where visitors can register and authenticate. Created with PHP, along with HTML and Bootstrap.

* **Users**. Users can either be `Subscriber` or `Admin`, where the Admin has full rights and full access to the functionality. Visitors can register by clicking on the `Register` link in the header. Newly registered users will be Subscribers, but an Admin can later elevate them to Admin status. Once logged in, both Subscribers and Admins can access the Control Panel.
* **Main Page**. This is the Main Page of the website which is the first page a visitor lands on. It shows a list of posts. Non-authenticated guests and logged in Subscribers can only see the `Published` posts while Admins can see both `Draft` and `Published` posts. Clicking on a post will take you to the post page, where you can `Like` and `Comment` on that post. Back to the Main Page, typing a post tag in the `Search` bar will return all the posts which have that tag. Clicking on a `Category` will show all the posts of that category. Clicking on an `Author Name` will give a list of all the posts created by that user. There is also an option for non-logged in users to authenticate. The main page also has `pagination`, so it only shows 5-6 posts per page.
* **Control Panel**. Accessed by clicking the link in the header as a signed in user. The Control Panel is different based on whether the user is a `Subscriber` or `Admin`. The Admin can access and manage anything, but a Subscriber can do so only for their own posts/comments. The following are the sections of the Control Panel:
1. **Dashboard**. It is the landing page of the Control Panel. It shows `statistics` for the posts, comments, users and categories. While Admins can see everything, Subscribers can only see data on their posts and comments and cannot see other users.
2. **Posts**. A post contains a title, author, category, image, tags, content as well as likes and comments and can be either Draft or Published. In this section, you can View, Add, Edit and Delete posts. You can also reset the views on each post. There is also an `Bulk Option` feature, where you can Publish, Draft, Delete or Clone multiple posts at the same time, using the checkboxes on the left and the dropdown select. The Admin can manage all posts, while the Subscriber can only manage their own. 
3. **Categories**. Here, the Admin can Add, Edit or Delete the categories that posts can be part of.
4. **Comments**. Each comment is tied to a post and a user. They can be `Approved` or `Unapproved`. Unapproved comments cannot be displayed in the posts comment section. Just like with posts, the Subscriber can only see their own comments.
5. **Users**. Here an Admin can manage the users of the website, as well as change their status to Admin or Subscriber. Subscribers do not have access to this section.
6. **Profile**. Here you can edit your own user details as well as change the password. All passwords are `encrypted` and saved in the database as the encrypted hashes.
7. **Other**. In the top-right corner of the Control Panel, you can see a `Users Online` tab which shows the number of users online on the website at the moment. Press Return to Home to go back to the Home Page and click on your Username to display a dropdown where you can `Log Out`.

### Login Data
Admin
```
Username: Tom
Password: tom
```
Subscriber
```
Username: Ben
Password: ben
```

