<?php

class Blockchain_Error extends Exception {}
class Blockchain_HttpError extends Blockchain_Error {}
class Blockchain_ApiError extends Blockchain_Error {}
class Blockchain_FormatError extends Blockchain_Error {}
class Blockchain_ParameterError extends Blockchain_Error {}
class Blockchain_CredentialsError extends Blockchain_Error {}
?>