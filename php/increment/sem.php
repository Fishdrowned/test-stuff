<?php
$ipcKey = crc32('lock');
$seqKey = crc32('uid');
//创建或获得一个现有的，以 $ipcKey 为KEY的信号量
$semId = sem_get($ipcKey);
//占有信号量，相当于上锁，同一时间内只有一个流程运行此段代码
sem_acquire($semId);

//创建或关联一个现有的，以 $ipcKey 为KEY的共享内存
$shmId = shm_attach($ipcKey, 64);
//从共享内存中获得序列号ID
$id = shm_get_var($shmId, $seqKey);
if ($id == null || $id >= 1000000000) {
	$id = 1;
} else {
	$id ++;
}
//将"++"后的ID写入共享内存
shm_put_var($shmId, $seqKey, $id);
//释放信号量，相当于解锁
sem_release($semId);
//关闭共享内存关联
shm_detach($shmId);
//sem_remove($semId);
var_dump($id);
