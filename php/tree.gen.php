<?php
// 原始数据
$rawData = [
	['id' => 1, 'content' => 'text1', 'parent' => 0, 'page' => 1],
	['id' => 2, 'content' => 'text2', 'parent' => 0, 'page' => 1],
	['id' => 3, 'content' => 'text3', 'parent' => 0, 'page' => 1],
	['id' => 4, 'content' => 'text3', 'parent' => 0, 'page' => 1],
	['id' => 5, 'content' => 'text5', 'parent' => 4, 'page' => 1],
	['id' => 6, 'content' => 'text5', 'parent' => 4, 'page' => 1],
	['id' => 7, 'content' => 'text7', 'parent' => 4, 'page' => 1],
	['id' => 8, 'content' => 'text8', 'parent' => 6, 'page' => 1],
	['id' => 9, 'content' => 'text9', 'parent' => 8, 'page' => 1],
	['id' => 10, 'content' => 'text10', 'parent' => 0, 'page' => 2],
	['id' => 11, 'content' => 'text11', 'parent' => 10, 'page' => 2],
	['id' => 12, 'content' => 'text12', 'parent' => 0, 'page' => 2],
	['id' => 13, 'content' => 'text13', 'parent' => 1, 'page' => 1],
	['id' => 14, 'content' => 'text14', 'parent' => 4, 'page' => 1],
];

// 期望结果
$expectedTree = [
	1 => [
		0 => [
			1 => [
				'value' => 1,
				13 => [
					'value' => 13,
				],
			],
			2 => [
				'value' => 2,
			],
			3 => [
				'value' => 3,
			],
			4 => [
				'value' => 4,
				5 => [
					'value' => 5,
				],
				6 => [
					'value' => 6,
					8 => [
						'value' => 8,
						9 => [
							'value' => 9,
						],
					],
				],
				7 => [
					'value' => 7,
				],
				14 => [
					'value' => 14,
				],
			],
		],
	],
	2 => [
		0 => [
			10 => [
				'value' => 10,
				11 => [
					'value' => 11,
				],
			],
			12 => [
				'value' => 12,
			],
		],
	],
];

$parents = [];
$data = [];
$tree = [];

foreach ($rawData as $row) {
	$data[$id = $row['id']] = $row;
	$parents[$id] = $parentId = $row['parent'];
}

foreach ($data as $k => &$row) {
	$parentId = $row['parent'];
	$parentChain = [$parentId => $parentId];
	while (isset($parents[$parentId])) {
		$parentId = $parents[$parentId];
		$parentChain[] = $parentId;
	}
	$parentChain = array_reverse($parentChain);
	$row['parent_chain'] = $parentChain;
}
unset($row);

foreach ($data as $k => $row) {
	$pageId = $row['page'];
	$parentChain = $row['parent_chain'];
	$tmp = &$tree[$pageId];
	$count = count($parentChain);
	foreach ($parentChain as $i => $parentId) {
		!isset($tmp[$parentId]) and $tmp[$parentId] = (isset($data[$parentId]) ? ['value' => $parentId] : []);
		$i == $count - 1 and $tmp[$parentId][$k]['value'] = $k;
		$tmp = &$tmp[$parentId];
	}
	unset($tmp);
}
echo '<pre>', var_export($data), '</pre>';
echo '<pre>', var_export($tree), '</pre>';

function treeToFlat($tree)
{
	$process = true;
	while ($process) {
		$flat = [];
		$process = false;
		foreach ($tree as $v) {
			if (is_array($v)) {
				$process = true;
				foreach ($v as $child) {
					$flat[] = $child;
				}
			} else {
				$flat[] = $v;
			}
		}
		$tree = $flat;
	}
	return $tree;
}

echo '<pre>', var_export(treeToFlat($tree[1])), '</pre>';
