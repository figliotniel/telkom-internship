import os

dir_path = r"c:\Users\Figlio Otniel\telkom-internship\resources\views"
old_hex = "991b1b"
new_hex = "ed1e28"

for root, _, files in os.walk(dir_path):
    for file in files:
        if file.endswith('.blade.php') or file.endswith('.html'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            if old_hex in content or old_hex.upper() in content:
                new_content = content.replace(old_hex, new_hex).replace(old_hex.upper(), new_hex)
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Updated {filepath}")
