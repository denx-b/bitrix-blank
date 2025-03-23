<?php

/*
 * Пример регисрации REST API метода
 */
AddEventHandler('rest', 'OnRestServiceBuildDescription', ['\Legacy\Rest\Test', 'init']);
