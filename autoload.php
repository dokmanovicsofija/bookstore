<?php
require_once  './Singleton/SessionManager.php';
require_once './Data/Repositories/Interfaces/AuthorRepositoryInterface.php';
require_once './Data/Repositories/Interfaces/BookRepositoryInterface.php';
require_once './Presentation/Controller/AuthorController.php';
require_once './Presentation/Controller/BookController.php';
require_once './Business/Interfaces/AuthorServiceInterface.php';
require_once './Business/Services/AuthorService.php';
require_once './Business/Services/BookService.php';
require_once './Data/Repositories/Session/AuthorRepositorySession.php';
require_once './Data/Repositories/Session/BookRepositorySession.php';

require_once './Presentation/Models/Author.php';
require_once './Business/Services/AuthorService.php';

