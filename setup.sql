--
-- IMPORTANT!
-- This script is prepared with MySQL/MariaDB in mind.
-- In case of other DBs you'll be probably better off recreating contents to suit your DB manually.
--


--
-- Create table with targets for monitoring
--

CREATE TABLE `targets`
(
    `id`       int(11) NOT NULL,
    `name`     varchar(256) COLLATE utf8_bin DEFAULT NULL,
    `url`      text COLLATE utf8_bin         DEFAULT NULL,
    `type`     varchar(256) COLLATE utf8_bin DEFAULT NULL,
    `category` varchar(256) COLLATE utf8_bin DEFAULT NULL,
    `timeout`  int(11)                       DEFAULT NULL COMMENT 'Timeout in seconds',
    `notifications_enabled`  int(1)   NULL   DEFAULT '0'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Create table with series of data
--

CREATE TABLE `data`
(
    `id`              int(11)    NOT NULL,
    `datetime`        int(11)    NOT NULL,
    `status`          tinyint(1) NOT NULL,
    `target_id`       int(11)    NOT NULL,
    `response_time`   float               DEFAULT NULL,
    `timeout_reached` int(1)     NOT NULL DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Sample entry
--

INSERT INTO `targets` (`id`, `name`, `url`, `type`, `category`, `timeout`) VALUES
(1, 'sample', 'https://jsonplaceholder.typicode.com/todos/1', 'json', NULL, NULL);

--
-- Set index and auto-increment
--
ALTER TABLE `targets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;