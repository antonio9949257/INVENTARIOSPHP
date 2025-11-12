
import re
import sys
import os

def remove_comments(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    file_extension = os.path.splitext(file_path)[1]

    if file_extension == '.php':
        # Remove PHP comments (//, #, /* */)
        # This regex is designed to be safe and not remove comment-like strings
        # It avoids matching // or # inside strings by looking for them at the start of a line or after whitespace
        # Multi-line comments /* */ are handled separately
        content = re.sub(r'/*[\s\S]*?*/', '', content) # Remove multi-line comments first
        content = re.sub(r'^\s*//[^\n]*\n?', '', content, flags=re.MULTILINE) # Remove // comments at start of line
        content = re.sub(r'^\s*#[^\n]*\n?', '', content, flags=re.MULTILINE) # Remove # comments at start of line
        content = re.sub(r'(?<!["\'])\s*//[^\n]*', '', content) # Remove // comments not in strings
        content = re.sub(r'(?<!["\'])\s*#[^\n]*', '', content) # Remove # comments not in strings
    elif file_extension == '.html':
        # Remove HTML comments <!-- -->
        content = re.sub(r'<!--[\s\S]*?-->', '', content)
    elif file_extension == '.css':
        # Remove CSS comments /* */
        content = re.sub(r'/*[\s\S]*?*/', '', content)
    elif file_extension == '.js':
        # Remove JavaScript comments (//, /* */)
        content = re.sub(r'/*[\s\S]*?*/', '', content) # Remove multi-line comments first
        content = re.sub(r'^\s*//[^\n]*\n?', '', content, flags=re.MULTILINE) # Remove // comments at start of line
        content = re.sub(r'(?<!["\'])\s*//[^\n]*', '', content) # Remove // comments not in strings

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python remove_comments.py <file_path>")
        sys.exit(1)
    
    file_to_process = sys.argv[1]
    if not os.path.exists(file_to_process):
        print(f"Error: File not found at {file_to_process}")
        sys.exit(1)
    
    remove_comments(file_to_process)
    print(f"Comments removed from {file_to_process}")
