<?php

namespace FrostieDE\EventableFlysystem\Event;

class FilesystemEvents {
    const BEFORE_HAS = 'flysystem.filesystem.before.has';
    const AFTER_HAS = 'flysystem.filesystem.after.has';

    const BEFORE_READ = 'flysystem.filesystem.before.read';
    const AFTER_READ = 'flysystem.filesystem.after.read';

    const BEFORE_READ_STREAM = 'flysystem.filesystem.before.read_stream';
    const AFTER_READ_STREAM = 'flysystem.filesystem.after.read_stream';

    const BEFORE_LIST_CONTENTS = 'flysystem.filesystem.before.list_contents';
    const AFTER_LIST_CONTENTS = 'flysystem.filesystem.after.list_contents';

    const BEFORE_GET_METADATA = 'flysystem.filesystem.before.get_metadata';
    const AFTER_GET_METADATA = 'flysystem.filesystem.after.get_metadata';

    const BEFORE_GET_SIZE = 'flysystem.filesystem.before.get_size';
    const AFTER_GET_SIZE = 'flysystem.filesystem.after.get_size';

    const BEFORE_GET_MIMETYPE = 'flysystem.filesystem.before.get_mimetype';
    const AFTER_GET_MIMETYPE = 'flysystem.filesystem.after.get_mimetype';

    const BEFORE_GET_TIMESTAMP = 'flysystem.filesystem.before.get_timestamp';
    const AFTER_GET_TIMESTAMP = 'flysystem.filesystem.after.get_timestamp';

    const BEFORE_GET_VISIBILITY = 'flysystem.filesystem.before.get_visibility';
    const AFTER_GET_VISIBILITY = 'flysystem.filesystem.after.get_visibility';

    const BEFORE_WRITE = 'flysystem.filesystem.before.write';
    const AFTER_WRITE = 'flysystem.filesystem.after.write';

    const BEFORE_WRITE_STREAM = 'flysystem.filesystem.before.write_stream';
    const AFTER_WRITE_STREAM = 'flysystem.filesystem.after.write_stream';

    const BEFORE_UPDATE = 'flysystem.filesystem.before.update';
    const AFTER_UPDATE = 'flysystem.filesystem.after.update';

    const BEFORE_UPDATE_STREAM = 'flysystem.filesystem.before.update_stream';
    const AFTER_UPDATE_STREAM = 'flysystem.filesystem.after.update_stream';

    const BEFORE_RENAME = 'flysystem.filesystem.before.rename';
    const AFTER_RENAME = 'flysystem.filesystem.after.rename';

    const BEFORE_COPY = 'flysystem.filesystem.before.copy';
    const AFTER_COPY = 'flysystem.filesystem.after.copy';

    const BEFORE_DELETE = 'flysystem.filesystem.before.delete';
    const AFTER_DELETE = 'flysystem.filesystem.after.delete';

    const BEFORE_DELETE_DIR = 'flysystem.filesystem.before.delete_dir';
    const AFTER_DELETE_DIR = 'flysystem.filesystem.after.delete_dir';

    const BEFORE_CREATE_DIR = 'flysystem.filesystem.before.create_dir';
    const AFTER_CREATE_DIR = 'flysystem.filesystem.after.create_dir';

    const BEFORE_SET_VISIBILITY = 'flysystem.filesystem.before.set_visibility';
    const AFTER_SET_VISIBILITY = 'flysystem.filesystem.after.set_visibility';

    const BEFORE_GET = 'flysystem.filesystem.before.get';
    const AFTER_GET = 'flysystem.filesystem.after.get';

    const BEFORE_ADD_PLUGIN = 'flysystem.filesystem.before.add_plugin';
    const AFTER_ADD_PLUGIN = 'flysystem.filesystem.after.add_plugin';

}