## API 

### Post

##### In list

- [x] Title
- [x] Author user data
- [x] Creation date
- [x] Excerpt
- [x] Number of bookmarks
- [x] Number of comments
- [x] Rating
- [x] Category (name, link, image) (**hidden on category page**)
- [x] User can report it
- [x] User can bookmark it
- [x] User can remove bookmark from it
- [x] User can like or dislike it
- [ ] **User can ignore the author of it**
- [ ] **User can hide it from timeline**
- [ ] 
- [ ] 

##### Full page

- [x] Title
- [x] Excerpt
- [x] **Content**
- [x] Author user (name, link, image)
- [ ] Author overall rating
- [x] Creation date
- [x] Number of bookmarks
- [x] Number of comments
- [x] **Number of views**
- [x] Rating
- [x] Category (name, link, image)
- [x] User can report it
- [x] User can bookmark it
- [x] User can remove bookmark from it
- [x] User can like or dislike it
- [ ]

##### Managing

- [ ] User can create new post
- [ ] Author can edit their post
- [ ] Author can delete their post

##### Admin / Moderator

- [ ] Can create post
- [ ] Can edit any post
- [ ] Can delete any post
- [ ] Post can be "locked" with no ability to comment on it



###### Maybe

- [ ] User can write to author
- [ ] User can subscribe to author
- [ ]
- [ ]


### Comment

- [x] Author (Name, link, image)
- [x] Content
- [x] Creation date
- [ ] Rating
- [x] Parent
- [x] 3 levels deep

##### User can:

- [x] Write it on post
- [x] Reply to it
- [ ] Like it
- [ ] Dislike it
- [ ] Bookmark it
- [x] Report it
- [ ] Get permalink to it that returns slice of discussion with all parents and replies to the given comment
- [ ] Ignore it, or author 
- [ ] Pin comment on their own post


### User 

- [x] Name
- [x] Short description
- [x] Profile picture
- [x] Banner
- [ ] Overall rating
- [x] Creation date
- [x] List of previous posts
- [ ] Previous posts are orderable
- [x] List of drafts
- [x] List of comments
- [ ] Comments are orderable
- [x] List of bookmarks - posts (private)
- [ ] List of bookmarks - comments (private)
- [x] Pinned post
- [ ] Can create posts
- [ ] Different user can subscribe
- [ ] Profile settings and user data
- [ ] Timeline for notification
- [ ] 
- [ ] 

##### Maybe
- [ ] QR code for mobile quick login
- [ ] Write a message to someone
- [ ] User can view on their own page list of notifications - with messages from subscribed comments
- [ ] 
- [ ] 


### Category

- [x] Title
- [x] Image
- [x] Banner
- [x] Description
- [x] Posts 
- [ ] Subscriber count

##### User can:

- [ ] Subscribe to it 
- [ ] unsubscribe from it
- [ ] Subscribed user timeline will display posts from it
- [ ] Ignore it
- [ ] Be responsible for categories
- [ ] Category posts are orderable
- [ ] 

##### Maybe

- [ ] Notifications
- [ ] ? Write a mini post from it when logged in
- [ ] ? User can write directly to the category
- [ ] ? User can report it
- [ ] 
- [ ] 


### Tag
- [x] Title
- [x] Posts
- [ ] Tag posts are orderable
- [ ] Logged in user can ignore it
- [ ] Created when user publishes new post with given tag
- [ ] 
- [ ] 

---

## Ideas and improvements

- [ ] Rating, bookmarks count, view count and other constantly changed values move to NoSql database (Mongo?)
- [ ] Editor can make titles and subtitles for table of content
- [ ] Progress bar for post length
- [ ] **User can share post (vk, facebook, twitter, telegram, ok, email)**

---

## FRONT

### Post

##### In list
- [x] Title
- [x] Author user data
- [x] Creation date
- [x] Excerpt
- [x] Number of bookmarks
- [x] Number of comments
- [x] Rating
- [x] Category (name, link, image) (**hidden on category page**)
- [ ] User can report it
- [ ] User can bookmark it
- [ ] User can remove bookmark from it
- [ ] User can upvote or downvote it
- [ ] **User can ignore the author of it**
- [ ] **User can hide it from timeline**
- [ ] 
- [ ] 

##### Full page
- [x] Title
- [x] Excerpt
- [x] **Content**
- [x] Author user (name, link, image)
- [ ] Author overall rating
- [x] Creation date
- [x] Number of bookmarks
- [x] Number of comments
- [x] **Number of views**
- [x] Rating
- [x] Category (name, link, image)
- [ ] User can report it
- [ ] User can bookmark it
- [ ] User can remove bookmark from it
- [ ] User can upvote or downvote it
- [ ] **User can share it (vk, facebook, twitter, telegram, ok, email)**
- [ ]
- [ ]

###### Maybe

- [ ] User can write to author
- [ ] User can subscribe to author
- [ ]
- [ ]


### Comments
- [x] Author (Name, link, image)
- [x] Content
- [x] Creation date
- [ ] Rating
- [x] Parent

##### User can:

- [ ] Write it on post
- [ ] Reply to it
- [ ] Upvote it
- [ ] Downvote it
- [ ] Bookmark it
- [ ] Report it
- [ ] Ignore it, or author 


### User 
- [x] Name
- [x] Short description
- [x] Profile picture
- [x] Banner
- [ ] Overall rating
- [x] Creation date
- [x] List of previous posts
- [x] List of drafts
- [x] List of comments (with commented post data)
- [x] List of bookmarks - posts (private)
- [ ] List of bookmarks - comments (private)
- [x] Pinned post
- [ ] Can create posts
- [ ] Different user can subscribe
- [ ] Profile settings and user data
- [ ] Timeline for notification
- [ ] 
- [ ] 

##### Maybe
- [ ] QR code for mobile quick login
- [ ] Write a message to someone
- [ ] User can view on their own page list of notifications - with messages from subscribed comments
- [ ] 
- [ ] 


### Category

- [x] Title
- [x] Image
- [x] Banner
- [x] Description
- [x] Posts 
- [ ] Subscriber count

##### User can:

- [ ] Subscribe to it 
- [ ] unsubscribe from it
- [ ] Subscribed user timeline will display posts from it
- [ ] Ignore it
- [ ] Be responsible for categories
- [ ] Category posts can be ordered by popularity and creation date
- [ ] 

##### Maybe

- [ ] Notifications
- [ ] ? Write a mini post from it when logged in
- [ ] ? User can write directly to the category
- [ ] ? User can report it
- [ ] 
- [ ] 


### Tag
- [ ] Title
- [ ] Posts
- [ ] Logged in user can ignore it
- [ ] Tag posts can be sorted by popularity or creation time
- [ ] Created when user publishes new post with given tag
- [ ] 
- [ ] 

