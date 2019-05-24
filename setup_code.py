import datetime
import os
import re
import sys

# get target filepath list from argv
target_list = sys.argv[1:]

# generate query from current datetime
query = '?' + datetime.datetime.now().strftime('%Y%m%d%H%M%S')

# strings of tags which query is not inserted
str_tags_not_inserted = ''

# process all files recursively
rootdir = 'resources/views'
for pathname, dirnames, filenames in os.walk(rootdir):
    for filename in filenames:
        # read
        file_path = os.path.join(pathname, filename)
        with open(file_path, 'r') as f:
            html = f.read()

        res = ''

        # search and process link/script-tag
        start = 0
        for match in re.finditer(r'<link|<script', html):
            found = match.start()
            res += html[start:found]
            start = found

            found = html.find('>', start)
            str_tag = html[start:found]

            # search '***.css'/'***.js' and insert query
            insert_idx_list = []
            for m in re.finditer(r'\.css|\.js', str_tag):
                idx_end = m.end()
                flg_fnd = False
                for target in target_list:
                    if str_tag[idx_end-len(target):idx_end] == target:
                        insert_idx_list.append(idx_end)
                        flg_fnd = True
                        break
                if not flg_fnd:
                    str_tags_not_inserted += '  ' + str_tag + '\n'
            for insert_idx in reversed(insert_idx_list):  # nessecery to reverse list because this process modify str_tag itself
                if str_tag[insert_idx] == '?':  # if query already exists
                    str_tag = str_tag[:insert_idx] + query + str_tag[insert_idx+15:]  # 15=len('?20190101235959')
                else:
                    str_tag = str_tag[:insert_idx] + query + str_tag[insert_idx:]

            res += str_tag
            start = found

        res += html[start:]

        # write
        with open(file_path, 'w') as f:
            f.write(res)

# print string of tags which query was not inserted
print('Tags which query was not inserted:')
print(str_tags_not_inserted[:-1])
