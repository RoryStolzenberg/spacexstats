<?php
namespace SpaceXStats\Enums;

abstract class UserRole {
	const Unauthenticated = 1;
	const Member = 2;
	const Subscriber = 3;
	const CharterSubscriber = 4;
	const Moderator = 5;
	const Administrator = 6;

	public static function getRole($num) {
		if ($num == 1) {
			return 'Unauthenticated';
		} elseif ($num == 2) {
			return 'Member';
		} elseif ($num == 3) {
			return 'Subscriber';
		} elseif ($num == 4) {
			return 'Charter Subscriber';
		} elseif ($num == 5) {
			return 'Moderator';
		} elseif ($num == 6) {
			return 'Administrator';
		}
	}
}