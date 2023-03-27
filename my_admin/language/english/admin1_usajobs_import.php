<?
define('HEADING_TITLE','USA JObs  Feed Import  Management');

define('TABLE_HEADING_CAMPAIGN_NAME','Campaign Name');
define('TABLE_HEADING_USAJOBS_USER_AGENT','User Agent ');
define('TABLE_HEADING_USAJOBS_LAST_ACTIVE','Last Active');
define('TABLE_HEADING_USAJOBS_IMPORT_JOBS','Import Jobs(last)');
define('TABLE_HEADING_USAJOBS_STATUS','Status');
define('TABLE_HEADING_USAJOBS_FATCH','Fatch');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_INFO_HEADING_CAMPAIGN','Campaign');
define('INFO_TEXT_STATUS','status :');
define('TEXT_INFO_CAMPAIGN_NAME','Campaign Name');
define('TEXT_INFO_USER_AGENT','User Agent');
define('TEXT_INFO_USAJOBS_AUTHORIZATION_KEY','Authorization-Key');
define('TEXT_INFO_RECRUITER_ID','Recruiter ID');
define('TEXT_INFO_LOCATION','Location');
define('TEXT_INFO_JOB_TITLE','Job Title');
define('TEXT_INFO_COUNTRY','Country');
define('TEXT_INFO_JOB_TYPE','Job Type');
define('TEXT_INFO_SORT_BY','Sort by');
define('TEXT_INFO_STATUS','Status');
define('TEXT_INFO_MAX_FEED','Max Feed / Keyword');
define('TEXT_INFO_KEYWORD','Keyword');
define('TEXT_INFO_JOB_DURATION','Job Duration');

define('STATUS_FEED_INACTIVE', 'Inactive');
define('STATUS_FEED_INACTIVATE', 'Inactivate?');

define('STATUS_FEED_ACTIVE', 'Active');
define('STATUS_FEED_ACTIVATE', 'Activate?');

define('MESSAGE_KEYWORD_ERROR','Please checked at leasst one check box.');
define('MESSAGE_NAME_ERROR','Sorry this campaign name already exists.');
define('MESSAGE_INVALID_RECRUITER_ERROR','Sorry this recruiter id not  exists.');
define('MESSAGE_INVALID_MAX_FEED_ERROR','Max Feed / Keyword must be greater then zero.');
define('MESSAGE_INVALID_JOB_DURATION_ERROR','Job duration must be greater then zero.');
define('MESSAGE_USER_AGENT_ERROR','Invalid User Agent.');
define('MESSAGE_CAMPAIGN_NAME_ERROR','Please enter campaign Name.');
define('MESSAGE_SUCCESS_DELETED','Success: feed importer Successfully deleted.');
define('MESSAGE_SUCCESS_INSERTED','Success: feed importer Successfully inserted.');
define('MESSAGE_SUCCESS_UPDATED','Success: feed importer Successfully updated.');

  

define('IMAGE_NEW','Add new feed importer');
define('IMAGE_CANCEL','Cancel');
define('IMAGE_INSERT','Insert feed importer');
define('IMAGE_EDIT','Edit feed importer');
define('IMAGE_UPDATE','Update feed importer');
define('IMAGE_DELETE','Delete feed importer');
define('IMAGE_CONFIRM','Confirm Delete feed importer');

define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this feed importer?');
define('TEXT_INFO_NEW_INTRO','Please enter the new feed importer  with its related data.');
define('TEXT_DISPLAY_NUMBER_OF_USAJOBS_IMPORTER', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> feed importers)');
define('TEXT_RECRUITER_ID_HELP','Use the ID mentioned in Recruiters section');
define('TEXT_AUTHORIZATION_KEY_HELP','Get Authorization-Key from <a href="https://developer.usajobs.gov/apirequest/" class="blue" target="_blank">https://developer.usajobs.gov/apirequest</a>');
?>