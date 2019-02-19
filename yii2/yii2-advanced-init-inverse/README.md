# yii2 advanced template init script inversion

Before developing application using yii2-advanced-template, you run *init* script to copy some files from *environment* direcotory to backend/frontend/comment directories.
These files are not commited into source code repository by default.

While developing, you may modify these files, especially main-local.php and params-local.php.
And you will need to store these files into *environment* directory to commit them into source code repository.

*init-inverse* help you to do this copy job.

Just put *init-inverse* into your program root, change run permission if neccessary and run ```./init-inverse```