<?php
namespace SpaceXStats\Library\Enums;

abstract class UserRole extends Enum {
	const Unauthenticated = 1;
	const Member = 2;
	const Subscriber = 3;
	const CharterSubscriber = 4;
	const Moderator = 5;
	const Administrator = 6;
}