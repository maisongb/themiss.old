<?php
namespace App\Lib\Exceptions;

class ActionUnauthorizedException extends \Exception{}
class ActionAlreadyDoneException extends \Exception{}
class ActionTechnicalException extends \Exception{}
class NotLoggedInException extends \Exception{}
class InvalidFileException extends \Exception{}

class NoTokenException extends \Exception {}
class ProviderNotConnectedException extends \Exception {}