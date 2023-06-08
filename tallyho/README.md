#Tallyho - Online Tournament Management (Visit: http://tallyho.in)

##Topics: 
1. First time user 
1. Push the changes 
1. Sync with team-members changes

##1. First time user
1. Launch a shell session (command in Windows) and change directory to _www_ 
1. Type command `git init`. It is assumed that you have git client installed on your computer
1. Type command git clone https://<your bitbucket username>@bitbucket.org/brevitylabs/tallyho.git. You may be asked for your bitbucket login-password
  - Check if all the source is downloaded to _tallyho_ folder. Create a PHP project using eclipse and import the source code in _tallyho_ folder. It is upto you to name the project. I call it _tallyho_.
1. Create a folder named _runtime_ in the folder /protected, and another folder named _assets_ under the project root _tallyho_.
1. It is assuming that you already have Eclipse installed. Install the latest Eclipse. I am using Mars but there are latest edition available. Note that Eclipse is git-aware and will help in check-in/out of the source.
1. Install WAMPServer, if Windows or install Apache, PHP5, MySQL individually. There are several YouTube videos citing installation of LAMP server where linking PHP5 and MySQL with the server is show step-by-step.
1. Install Yii 1.1.16 framework in _www_ folder. It is just copying and unzipping the framework. Yii 1.1.16 is not bundled in this repository because of its size and futility.
1. Install d3.js in _www_ folder. It is also just copying and unzipping the framework. This micro-framework is available at http://d3js.org (direct link - https://github.com/mbostock/d3/archive/master.zip).
1. Create a new db in MySQL called _tally64g_tallyho_ and run the data-script _data-model v2.0.sql_ available inside the project folder apps/data-model.
1. MySQL user called _tally64g_tallyho_ should be created and linked with the DB by the same name. Set the password to _c!90zog*t^P_ .


##2. Push the changes
1. Launch a shell session (command in Windows) and change directory to _tallyho_ 
1. If there are no new files added by you, then skip step 3.
1. Type command to add new files - `git add *`. You can use filenames instead of the wild-card or a combination. 
1. Type command `git commit -m "<your comments on the changes>"` 
1. Type command `git push https://<your bitbucket username>@bitbucket.org/brevitylabs/tallyho.git master`
	

##3. Sync team-member's changes
1. Launch a shell session (command in Windows) and change directory to _tallyho_ 
1. Type command `it pull https://<your bitbucket username>@bitbucket.org/brevitylabs/tallyho.git master`
