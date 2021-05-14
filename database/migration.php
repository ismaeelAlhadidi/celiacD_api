<?php 
return [

    'users' => 'CREATE TABLE users (
        UserId integer PRIMARY KEY AUTO_INCREMENT,
        FName varchar(25) not null, 
        LName varchar(25) not null,
        UserName varchar(25) not null unique,
        PhoneNo char(10) not null unique,
        Email varchar(255) not null unique, 
        Password varchar(255) not null,
        ProfilePic text,
        UserType int not null
    );',

    /*
        UserType => [
            'user' => 1,
            'doctor' => 2,
            'store' => 3
        ]
    */

    'doctors' => 'CREATE TABLE doctors (
        DoctorId integer PRIMARY KEY,
        DoctorIdNo varchar(255) not null unique,
        Specialization varchar(255) not null,
        Location varchar(255),
        AboutMe text,
        ClinicName text,
        MedicalSchoolName text,
        Foreign key(DoctorId) References users(UserId) on delete cascade on update cascade
    );',

    'stores' => 'CREATE TABLE stores (
        StoretId integer PRIMARY KEY,
        CommercialRegistrationNo varchar(255) not null unique,
        StoreName text not null,
        StoreType text not null,
        Location varchar(255),
        AboutMe text,
        WorkingHours float,
        Foreign key(StoretId) References users(UserId) on delete cascade on update cascade
    );',
    
    'items' => 'CREATE TABLE items (
        ItemId integer PRIMARY KEY AUTO_INCREMENT,
        StoretId integer,
        ItemName text,
        ItemPrice float,
        Description text,
        ItemImg text,
        Foreign key(StoretId) References stores(StoretId) on delete cascade on update cascade
    );',

    'posts' => 'CREATE TABLE posts (
        PostID integer PRIMARY KEY AUTO_INCREMENT,
        UserId integer,
        PostContent varchar(255),
        PostDate datetime,
        PostType text,
        PostImage text,
        Foreign key(UserId) references users(UserId) on delete cascade on update cascade
    );',

    'followings' => 'CREATE TABLE followings (
        FollowingId int not null PRIMARY KEY AUTO_INCREMENT,
        PatientId integer,
        UserId integer,
        FOREIGN KEY(PatientId) REFERENCES users(UserId) on delete cascade on update cascade,
        FOREIGN KEY(UserId) REFERENCES users(UserId) on delete cascade on update cascade
    );',

    'rates' => 'CREATE TABLE rates (
        RateId int not null PRIMARY KEY AUTO_INCREMENT,
        PatientId integer,
        UserId integer,
        RateValue integer,
        FOREIGN KEY(PatientId) REFERENCES users(UserId) on delete cascade on update cascade,
        FOREIGN KEY(UserId) REFERENCES users(UserId) on delete cascade on update cascade
    );',

    'questions' => 'CREATE TABLE questions (
        QuestionsID int not null PRIMARY KEY AUTO_INCREMENT,
        Content varchar(5000) not null,
        UserId int not null,
        Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(UserId) REFERENCES users(UserId) on delete cascade on update cascade
    );',

    'favourites' => 'CREATE TABLE favourites (
        FavouriteId int not null PRIMARY KEY AUTO_INCREMENT,
        PatientId integer,
        UserId integer,
        QuestionsID integer null,
        FOREIGN KEY(PatientId) REFERENCES users(UserId) on delete cascade on update cascade,
        FOREIGN KEY(QuestionsID) REFERENCES questions(QuestionsID) on delete cascade on update cascade,
        FOREIGN KEY(UserId) REFERENCES users(UserId) on delete cascade on update cascade
    );',

    'answers' => 'CREATE TABLE answers (
        AnswerId int not null PRIMARY KEY AUTO_INCREMENT,
        Content varchar(5000) not null,
        QuestionsID int not null,
        UserId int not null,
        Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(UserId) REFERENCES users(UserId) on delete cascade on update cascade,
        FOREIGN KEY(QuestionsID) REFERENCES questions(QuestionsID) on delete cascade on update cascade
    );',
    
];
