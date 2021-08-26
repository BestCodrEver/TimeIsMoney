<?php

namespace Soulz\TimeIsMoney;

class Utils {

    public const DECLINE = TextFormat::GRAY . "[" . TextFormat::BOLD . TextFormat::DARK_RED . "-" . TextFormat::RESET . TextFormat::GRAY . "]" . TextFormat::RESET;

    public const INCLINE = TextFormat::GRAY . "[" . TextFormat::BOLD . TextFormat::DARK_GREEN . "+" . TextFormat::RESET . TextFormat::GRAY . "]" . TextFormat::RESET;
}
