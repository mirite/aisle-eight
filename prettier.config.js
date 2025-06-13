import { prettierWithTW } from "@mirite/eslint-config-mirite";

const base = prettierWithTW("./resources/css/app.css");
export default {
	...base,
	overrides: [
		{
			files: ["*.blade.php"],
			options: {
				parser: "blade",
				tabWidth: 4,
			},
		},
	],
	plugins: ["@shufo/prettier-plugin-blade", ...base.plugins],
};
