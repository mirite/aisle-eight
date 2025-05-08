export default {
    plugins: [
        "prettier-plugin-packagejson",
        "@ianvs/prettier-plugin-sort-imports",
        "@shufo/prettier-plugin-blade",
        "prettier-plugin-tailwindcss",
    ],
    tailwindStylesheet: "./resources/css/app.css",
    overrides: [
        {
            files: ["*.blade.php"],
            options: {
                parser: "blade",
                tabWidth: 4,
            },
        },
    ],
};
